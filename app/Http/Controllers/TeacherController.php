<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────
    public function dashboard()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->withCount('enrollments')
            ->withCount('assignments')
            ->withCount('lectures')
            ->latest()
            ->get();
        return view('teacher.dashboard', compact('courses'));
    }

    // ── Courses ────────────────────────────────────────────────
    public function createCourse()
    {
        return view('teacher.create_course');
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create([
            'title'       => $request->title,
            'description' => $request->description,
            'teacher_id'  => Auth::id(),
        ]);

        return redirect()->route('teacher.dashboard')->with('success', 'Course created successfully!');
    }

    // ── Assignments ────────────────────────────────────────────
    public function courseAssignments(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);
        $assignments = $course->assignments()->withCount('submissions')->latest()->get();
        return view('teacher.assignments', compact('course', 'assignments'));
    }

    public function createAssignment(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);
        return view('teacher.create_assignment', compact('course'));
    }

    public function storeAssignment(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'required|date',
            'notes_file'  => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $notesPath = null;
        if ($request->hasFile('notes_file')) {
            $notesPath = $request->file('notes_file')->store('notes', 'public');
        }

        Assignment::create([
            'course_id'   => $course->id,
            'title'       => $request->title,
            'description' => $request->description,
            'due_date'    => $request->due_date,
            'notes_file'  => $notesPath,
        ]);

        return redirect()->route('teacher.assignments', $course)->with('success', 'Assignment created successfully!');
    }

    // ── Submissions ────────────────────────────────────────────
    public function submissions(Assignment $assignment)
    {
        if ($assignment->course->teacher_id !== Auth::id()) abort(403);
        $submissions = $assignment->submissions()->with('student')->latest()->get();
        return view('teacher.submissions', compact('assignment', 'submissions'));
    }

    public function assignMarks(Request $request, Submission $submission)
    {
        $request->validate(['marks' => 'required|integer|min:0|max:100']);
        $submission->update(['marks' => $request->marks]);
        return back()->with('success', 'Marks assigned successfully!');
    }

    public function downloadSubmission(Submission $submission)
    {
        // Only the teacher of that course can download
        if ($submission->assignment->course->teacher_id !== Auth::id()) abort(403);

        $path = $submission->file;
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }
        return Storage::disk('public')->download($path);
    }

    // ── Lectures ───────────────────────────────────────────────
    public function courseLectures(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);
        $lectures = $course->lectures()->latest()->get();
        return view('teacher.lectures', compact('course', 'lectures'));
    }

    public function createLecture(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);
        return view('teacher.create_lecture', compact('course'));
    }

    public function storeLecture(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) abort(403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'lecture_file'=> 'required|file|mimes:pdf,doc,docx|max:20480',
        ]);

        $file     = $request->file('lecture_file');
        $ext      = strtolower($file->getClientOriginalExtension());
        $fileType = ($ext === 'pdf') ? 'pdf' : 'word';
        $path     = $file->store('lectures', 'public');

        Lecture::create([
            'course_id'   => $course->id,
            'teacher_id'  => Auth::id(),
            'title'       => $request->title,
            'description' => $request->description,
            'file'        => $path,
            'file_type'   => $fileType,
        ]);

        return redirect()->route('teacher.lectures', $course)->with('success', 'Lecture uploaded successfully!');
    }

    public function deleteLecture(Lecture $lecture)
    {
        if ($lecture->teacher_id !== Auth::id()) abort(403);
        Storage::disk('public')->delete($lecture->file);
        $lecture->delete();
        return back()->with('success', 'Lecture deleted successfully!');
    }
}
