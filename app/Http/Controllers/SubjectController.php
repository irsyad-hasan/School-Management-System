<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index(): View
    {
        $subjects = Subject::where('archived', false)
            ->latest('subject_id')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create(): View
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:100',
            ],
            'subject_code' => [
                'required',
                'string',
                'max:20',
                'unique:tbl_subjects,subject_code',
            ],
            'jp' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
        ]);

        $subject = Subject::create([
            'subject_name' => $validated['subject_name'],
            'subject_code' => $validated['subject_code'],
            'jp' => $validated['jp'],
            'archived' => false,
        ]);

        $subject->slug = Str::slug(
            $subject->subject_name . '-' . $subject->subject_id
        );

        $subject->save();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject): View
    {
        $this->ensureActive($subject);

        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject): View
    {
        $this->ensureActive($subject);

        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject.
     */
    public function update(
        Request $request,
        Subject $subject
    ): RedirectResponse {
        $this->ensureActive($subject);

        $validated = $request->validate([
            'subject_name' => [
                'required',
                'string',
                'max:100',
            ],
            'subject_code' => [
                'required',
                'string',
                'max:20',
                'unique:tbl_subjects,subject_code,' . $subject->subject_id . ',subject_id',
            ],
            'jp' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
        ]);

        $subject->update([
            'subject_name' => $validated['subject_name'],
            'subject_code' => $validated['subject_code'],
            'jp' => $validated['jp'],
        ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Archive the specified subject.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $this->ensureActive($subject);

        $subject->update([
            'archived' => true,
        ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Subject archived successfully.');
    }

    private function ensureActive(Subject $subject): void
    {
        abort_if($subject->archived, 404);
    }
}