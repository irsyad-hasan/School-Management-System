<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(): View
    {
        $teachers = Teacher::with(['subject', 'homeroomClasses'])
            ->where('archived', false)
            ->latest('teacher_id')
            ->get();

        if (Auth::user()->role === 'teacher') {
            $teachers->each(fn (Teacher $item) => $item->makeHidden(['nip']));
        }

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create(): View
    {
        $subjects = Subject::where('archived', false)
            ->orderBy('subject_name')
            ->get();

        return view('teachers.create', compact('subjects'));
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:tbl_users,username',
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:tbl_users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'nip' => [
                'required',
                'string',
                'max:30',
                'unique:tbl_teachers,nip',
            ],
            'subject_id' => [
                'required',
                Rule::exists('tbl_subjects', 'subject_id')
                    ->where('archived', false),
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
                'archived' => false,
            ]);

            $teacher = Teacher::create([
                'user_id' => $user->user_id,
                'full_name' => $validated['full_name'],
                'nip' => $validated['nip'],
                'subject_id' => $validated['subject_id'],
                'archived' => false,
            ]);

            $teacher->slug = Str::slug(
                $teacher->full_name . '-' . $teacher->teacher_id
            );

            $teacher->save();
        });

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified teacher.
     */
    public function show(Teacher $teacher): View
    {
        $this->ensureActive($teacher);

        $teacher->load(['subject', 'user', 'homeroomClasses']);

        if (Auth::user()->role === 'teacher' && Auth::user()->teacher?->teacher_id !== $teacher->teacher_id) {
            $teacher->makeHidden(['nip']);
        }

        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit(Teacher $teacher): View
    {
        $this->ensureActive($teacher);

        $subjects = Subject::where('archived', false)
            ->orderBy('subject_name')
            ->get();

        $teacher->load('user');

        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(
        Request $request,
        Teacher $teacher
    ): RedirectResponse {
        $this->ensureActive($teacher);

        $teacher->load('user');

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tbl_users', 'username')
                    ->ignore($teacher->user->user_id, 'user_id'),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('tbl_users', 'email')
                    ->ignore($teacher->user->user_id, 'user_id'),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'full_name' => [
                'required',
                'string',
                'max:100',
            ],
            'nip' => [
                'required',
                'string',
                'max:30',
                Rule::unique('tbl_teachers', 'nip')
                    ->ignore($teacher->teacher_id, 'teacher_id'),
            ],
            'subject_id' => [
                'required',
                Rule::exists('tbl_subjects', 'subject_id')
                    ->where('archived', false),
            ],
        ]);

        DB::transaction(function () use ($validated, $teacher) {
            $teacher->user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $teacher->user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            $teacher->update([
                'full_name' => $validated['full_name'],
                'nip' => $validated['nip'],
                'subject_id' => $validated['subject_id'],
            ]);
        });

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Archive the specified teacher.
     *
     * The teacher's subject will also be archived
     * when it is no longer used by another active teacher.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->ensureActive($teacher);

        DB::transaction(function () use ($teacher) {
            $subject = $teacher->subject;

            // Lepaskan teacher dari kelas yang menggunakan
            // teacher tersebut sebagai wali kelas.
            SchoolClass::where('homeroom_teacher_id', $teacher->teacher_id)
                ->update([
                    'homeroom_teacher_id' => null,
                ]);

            // Archive teacher.
            $teacher->update([
                'archived' => true,
            ]);

            // Archive teacher's user account.
            $teacher->user->update([
                'archived' => true,
            ]);

            // Archive subject jika sudah tidak digunakan
            // oleh teacher aktif lainnya.
            if ($subject) {
                $activeTeacherCount = Teacher::where(
                    'subject_id',
                    $subject->subject_id
                )
                    ->where('archived', false)
                    ->count();

                if ($activeTeacherCount === 0) {
                    $subject->update([
                        'archived' => true,
                    ]);
                }
            }
        });

        return redirect()
            ->route('teachers.index')
            ->with(
                'success',
                'Guru dan data terkait berhasil diarsipkan.'
            );
    }

    /**
     * Ensure the teacher is still active.
     */
    private function ensureActive(Teacher $teacher): void
    {
        abort_if($teacher->archived, 404);
    }
}