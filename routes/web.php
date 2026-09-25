<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = \Illuminate\Support\Facades\Auth::user();

    $userCount = null;
    $studentCount = null;
    $teacherCount = null;
    $classCount = null;
    $subjectCount = null;
    $student = null;
    $recentStudents = collect();

    if ($user->role === 'admin') {
        $userCount = \App\Models\User::where('archived', false)->count();
        $studentCount = Student::where('archived', false)->count();
        $teacherCount = Teacher::where('archived', false)->count();
        $classCount = SchoolClass::where('archived', false)->count();
        $subjectCount = Subject::where('archived', false)->count();

        $recentStudents = Student::with('schoolClass')
            ->latest('student_id')
            ->take(5)
            ->get();
    }

    if ($user->role === 'student') {
        $student = $user->student;

        if ($student) {
            $student->load('schoolClass');
        }
    }

    return view('dashboard', compact(
        'userCount',
        'studentCount',
        'teacherCount',
        'classCount',
        'subjectCount',
        'student',
        'recentStudents'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('students.create');

        Route::post('/students', [StudentController::class, 'store'])
            ->name('students.store');

        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])
            ->name('students.edit');

        Route::put('/students/{student}', [StudentController::class, 'update'])
            ->name('students.update');

        Route::delete('/students/{student}', [StudentController::class, 'destroy'])
            ->name('students.destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/teachers/create', [TeacherController::class, 'create'])
            ->name('teachers.create');

        Route::post('/teachers', [TeacherController::class, 'store'])
            ->name('teachers.store');

        Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])
            ->name('teachers.edit');

        Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])
            ->name('teachers.update');

        Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])
            ->name('teachers.destroy');
    });

    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/teachers', [TeacherController::class, 'index'])
            ->name('teachers.index');

        Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])
            ->name('teachers.show');
    });

    Route::middleware('role:admin,teacher,student')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])
            ->name('students.index');

        Route::get('/students/{student}', [StudentController::class, 'show'])
            ->name('students.show');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/classes/create', [ClassController::class, 'create'])
            ->name('classes.create');

        Route::post('/classes', [ClassController::class, 'store'])
            ->name('classes.store');

        Route::get('/classes/{class}/edit', [ClassController::class, 'edit'])
            ->name('classes.edit');

        Route::put('/classes/{class}', [ClassController::class, 'update'])
            ->name('classes.update');

        Route::delete('/classes/{class}', [ClassController::class, 'destroy'])
            ->name('classes.destroy');
    });

    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/classes', [ClassController::class, 'index'])
            ->name('classes.index');

        Route::get('/classes/{class}', [ClassController::class, 'show'])
            ->name('classes.show');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/subjects/create', [SubjectController::class, 'create'])
            ->name('subjects.create');

        Route::post('/subjects', [SubjectController::class, 'store'])
            ->name('subjects.store');

        Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])
            ->name('subjects.edit');

        Route::put('/subjects/{subject}', [SubjectController::class, 'update'])
            ->name('subjects.update');

        Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])
            ->name('subjects.destroy');
    });

    Route::middleware('role:admin,teacher')->group(function () {
        Route::get('/subjects', [SubjectController::class, 'index'])
            ->name('subjects.index');

        Route::get('/subjects/{subject}', [SubjectController::class, 'show'])
            ->name('subjects.show');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
