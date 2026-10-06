<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $query = Schedule::with(['schoolClass','teacher','subject'])->where('archived', false);
        if (Auth::user()->role === 'teacher') {
            $teacher = Auth::user()->teacher;
            $query->where('teacher_id', $teacher?->teacher_id ?? 0);
        }
        $schedules = $query->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('start_time')->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create(): View
    {
        return view('schedules.create', [
            'classes' => SchoolClass::where('archived', false)->orderBy('class_name')->get(),
            'teachers' => Teacher::with('subject')->where('archived', false)->orderBy('full_name')->get(),
            'subjects' => Subject::where('archived', false)->orderBy('subject_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        Schedule::create($data);
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Schedule $schedule): View
    {
        abort_if($schedule->archived, 404);
        $this->authorizeTeacher($schedule);
        $schedule->load(['schoolClass','teacher','subject']);
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule): View
    {
        abort_if($schedule->archived, 404);
        $this->authorizeTeacher($schedule);
        return view('schedules.edit', [
            'schedule' => $schedule,
            'classes' => SchoolClass::where('archived', false)->orderBy('class_name')->get(),
            'teachers' => Teacher::with('subject')->where('archived', false)->orderBy('full_name')->get(),
            'subjects' => Subject::where('archived', false)->orderBy('subject_name')->get(),
        ]);
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        abort_if($schedule->archived, 404);
        $data = $this->validateData($request);
        $schedule->update($data);
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        abort_if($schedule->archived, 404);
        $schedule->update(['archived' => true]);
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diarsipkan.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'class_id' => ['required','exists:tbl_classes,class_id'],
            'teacher_id' => ['required','exists:tbl_teachers,teacher_id'],
            'subject_id' => ['required','exists:tbl_subjects,subject_id'],
            'day' => ['required','in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu'],
            'start_time' => ['required','date_format:H:i'],
            'end_time' => ['required','date_format:H:i','after:start_time'],
            'jp' => ['required','integer','min:1','max:12'],
        ]);
    }

    private function authorizeTeacher(Schedule $schedule): void
    {
        if (Auth::user()->role === 'teacher' && $schedule->teacher_id !== Auth::user()->teacher?->teacher_id) {
            abort(403);
        }
    }
}
