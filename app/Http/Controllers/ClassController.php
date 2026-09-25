<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    /**
     * Display a listing of classes.
     */
    public function index(): View
    {
        $classes = SchoolClass::with('homeroomTeacher')
            ->where('archived', false)
            ->latest('class_id')
            ->paginate(10);

        return view('classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create(): View
    {
        $teachers = Teacher::with('subject')
            ->where('archived', false)
            ->orderBy('full_name')
            ->get();

        return view('classes.create', compact('teachers'));
    }

    /**
     * Store a newly created class.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_name' => [
                'required',
                'string',
                'max:50',
            ],
            'homeroom_teacher_id' => [
                'nullable',
                Rule::exists('tbl_teachers', 'teacher_id')
                    ->where('archived', false),
            ],
            'academic_year' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        $class = SchoolClass::create([
            'class_name' => $validated['class_name'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
            'academic_year' => $validated['academic_year'],
            'archived' => false,
        ]);

        $class->slug = Str::slug(
            $class->class_name . '-' . $class->class_id
        );

        $class->save();

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    /**
     * Display the specified class.
     */
    public function show(SchoolClass $class): View
    {
        $this->ensureActive($class);

        $class->load([
            'homeroomTeacher.subject',
            'students' => function ($query) {
                $query->where('archived', false)
                    ->orderBy('full_name');
            },
        ]);

        return view('classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(SchoolClass $class): View
    {
        $this->ensureActive($class);

        $teachers = Teacher::with('subject')
            ->where('archived', false)
            ->orderBy('full_name')
            ->get();

        return view('classes.edit', compact('class', 'teachers'));
    }

    /**
     * Update the specified class.
     */
    public function update(
        Request $request,
        SchoolClass $class
    ): RedirectResponse {
        $this->ensureActive($class);

        $validated = $request->validate([
            'class_name' => [
                'required',
                'string',
                'max:50',
            ],
            'homeroom_teacher_id' => [
                'nullable',
                Rule::exists('tbl_teachers', 'teacher_id')
                    ->where('archived', false),
            ],
            'academic_year' => [
                'required',
                'string',
                'max:20',
            ],
        ]);

        $class->update([
            'class_name' => $validated['class_name'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
            'academic_year' => $validated['academic_year'],
        ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Archive the specified class.
     */
    public function destroy(SchoolClass $class): RedirectResponse
    {
        $this->ensureActive($class);

        $class->update([
            'archived' => true,
        ]);

        return redirect()
            ->route('classes.index')
            ->with('success', 'Class archived successfully.');
    }

    private function ensureActive(SchoolClass $class): void
    {
        abort_if($class->archived, 404);
    }
}