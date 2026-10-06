<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;



class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(): View
    {
        if (Auth::user()->role === 'student') {
            $student = Auth::user()->student;

            abort_unless($student, 404);

            $student->load(['schoolClass', 'user']);

            return view('students.show', compact('student'));
        }

        $students = Student::with('schoolClass')
            ->where('archived', false)
            ->latest('student_id')
            ->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create(): View
    {
        $classes = SchoolClass::where('archived', false)
            ->orderBy('class_name')
            ->get();

        return view('students.create', compact('classes'));
    }

    /**
     * Store a newly created student.
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
            'nis' => [
                'required',
                'string',
                'max:30',
                'unique:tbl_students,nis',
            ],
            'class_id' => [
                'required',
                Rule::exists('tbl_classes', 'class_id')
                    ->where('archived', false),
            ],
            'date_of_birth' => [
                'required',
                'date',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'student',
                'archived' => false,
            ]);

            $student = Student::create([
                'user_id' => $user->user_id,
                'full_name' => $validated['full_name'],
                'nis' => $validated['nis'],
                'class_id' => $validated['class_id'],
                'date_of_birth' => $validated['date_of_birth'],
                'archived' => false,
            ]);

            $student->slug = Str::slug(
                $student->full_name . '-' . $student->student_id
            );

            $student->save();
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }


    /**
     * Display the specified student.
     */
    public function show(Student $student): View
    {
        $this->ensureActive($student);

        if (Auth::user()->role === 'student') {
            abort_unless(
                $student->user_id === Auth::id(),
                403
            );
        }

        $student->load([
            'schoolClass',
            'user',
        ]);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student): View
    {
        $this->ensureActive($student);

        $classes = SchoolClass::where('archived', false)
            ->orderBy('class_name')
            ->get();

        $student->load('user');

        return view('students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $this->ensureActive($student);

        $student->load('user');

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tbl_users', 'username')
                    ->ignore($student->user->user_id, 'user_id'),
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('tbl_users', 'email')
                    ->ignore($student->user->user_id, 'user_id'),
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
            'nis' => [
                'required',
                'string',
                'max:30',
                Rule::unique('tbl_students', 'nis')
                    ->ignore($student->student_id, 'student_id'),
            ],
            'class_id' => [
                'required',
                Rule::exists('tbl_classes', 'class_id')
                    ->where('archived', false),
            ],
            'date_of_birth' => [
                'required',
                'date',
            ],
        ]);

        DB::transaction(function () use ($validated, $student) {
            $student->user->update([
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $student->user->update([
                    'password' => Hash::make($validated['password']),
                ]);
            }

            $student->update([
                'full_name' => $validated['full_name'],
                'nis' => $validated['nis'],
                'class_id' => $validated['class_id'],
                'date_of_birth' => $validated['date_of_birth'],
            ]);
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Archive the specified student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->ensureActive($student);

        DB::transaction(function () use ($student) {
            $student->update([
                'archived' => true,
            ]);

            $student->user->update([
                'archived' => true,
            ]);
        });

        return redirect()
            ->route('students.index')
            ->with('success', 'Student archived successfully.');
    }

    private function ensureActive(Student $student): void
    {
        abort_if($student->archived, 404);
    }
}