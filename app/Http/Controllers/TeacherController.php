<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(): View
    {
        $teachers = Teacher::with('subject')
            ->where('archived', false)
            ->latest('teacher_id')
            ->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    public function create(): View
    {
        $subjects = Subject::where('archived', false)
            ->orderBy('subject_name')
            ->get();

        return view('teachers.create', compact('subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:tbl_users,username'],
            'email' => ['required', 'email', 'max:100', 'unique:tbl_users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'full_name' => ['required', 'string', 'max:100'],
            'nip' => ['required', 'string', 'max:30', 'unique:tbl_teachers,nip'],
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

    public function show(Teacher $teacher): View
    {
        $this->ensureActive($teacher);

        $teacher->load(['subject', 'user', 'homeroomClass']);

        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher): View
    {
        $this->ensureActive($teacher);

        $subjects = Subject::where('archived', false)
            ->orderBy('subject_name')
            ->get();

        $teacher->load('user');

        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
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
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'full_name' => ['required', 'string', 'max:100'],
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

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $this->ensureActive($teacher);

        DB::transaction(function () use ($teacher) {
            $teacher->update(['archived' => true]);
            $teacher->user->update(['archived' => true]);
        });

        return redirect()
            ->route('teachers.index')
            ->with('success', 'Teacher archived successfully.');
    }

    private function ensureActive(Teacher $teacher): void
    {
        abort_if($teacher->archived, 404);
    }
}