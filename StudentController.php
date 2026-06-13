<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Lecture;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // ── Dashboard ──────────────────────────────────────────────
    public function dashboard()
    {
        $enrolledIds      = Enrollment::where('student_id', Auth::id())->pluck('course_id');
        $enrolledCourses  = Course::whereIn('id', $enrolledIds)->with('teacher')->get();
        $availableCourses = Course::whereNotIn('id', $enrolledIds)->with('teacher')->get();
        return view('student.dashboard', compact('enrolledCourses', 'availableCourses'));
    }

    // ── Enroll ─────────────────────────────────────────────────
    public function enroll(Course $course)
    {
        $exists = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)->exists();

        if (!$exists) {
            Enrollment::create(['student_id' => Auth::id(), 'course_id' => $course->id]);
            return back()->with('success', 'You have enrolled in this course!');
        }
        return back()->with('info', 'You are already enrolled.');
    }

    // ── Course Detail (Assignments + Lectures) ─────────────────
    public function courseDetail(Course $course)
    {
        $enrolled = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $course->id)->exists();
        if (!$enrolled) abort(403, 'Please enroll first.');

        $assignments  = $course->assignments()->latest()->get();
        $lectures     = $course->lectures()->latest()->get();
        $submittedIds = Submission::where('student_id', Auth::id())
            ->whereIn('assignment_id', $assignments->pluck('id'))
            ->pluck('assignment_id')->toArray();

        return view('student.course_detail', compact('course', 'assignments', 'lectures', 'submittedIds'));
    }

    // ── Submit Assignment ──────────────────────────────────────
    public function submitForm(Assignment $assignment)
    {
        return view('student.submit_form', compact('assignment'));
    }

    public function submitAssignment(Request $request, Assignment $assignment)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = $request->file('file')->store('submissions', 'public');

        Submission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => Auth::id()],
            ['file' => $path, 'marks' => null]
        );

        return redirect()->route('student.dashboard')->with('success', 'Assignment submitted successfully!');
    }

    // ── Download Lecture ───────────────────────────────────────
    public function downloadLecture(Lecture $lecture)
    {
        // Check student is enrolled in this course
        $enrolled = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $lecture->course_id)->exists();
        if (!$enrolled) abort(403, 'You are not enrolled in this course.');

        if (!Storage::disk('public')->exists($lecture->file)) {
            abort(404, 'File not found.');
        }
        return Storage::disk('public')->download($lecture->file);
    }

    // ── Download Assignment Notes ──────────────────────────────
    public function downloadNote($filename)
    {
        $path = 'notes/' . $filename;
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }
        return Storage::disk('public')->download($path);
    }

    // ── Marks ──────────────────────────────────────────────────
    public function marks()
    {
        $submissions = Submission::where('student_id', Auth::id())
            ->with('assignment.course')
            ->latest()
            ->get();
        return view('student.marks', compact('submissions'));
    }

    // ── AI Assistant ───────────────────────────────────────────
    public function aiPage()
    {
        return view('student.ai');
    }

    public function askAI(Request $request)
    {
        $request->validate(['question' => 'required|string|max:1000']);

        // Fix: use firstOrCreate so Settings record always exists
        $setting = Setting::firstOrCreate([], ['gemini_api_key' => null]);
        $apiKey  = $setting->gemini_api_key;

        if (!$apiKey) {
            return back()
                ->withErrors(['question' => 'AI is not configured yet. Please contact your admin.'])
                ->withInput();
        }

        $question = $request->question;
        $answer   = 'No response received.';

        try {
            $response = Http::timeout(30)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [[
                        'parts' => [[
                            'text' => "You are a helpful educational AI assistant. Answer the student's question clearly and simply. Reply in English or Urdu depending on what language the student used.\n\nStudent question: {$question}"
                        ]]
                    ]],
                    'generationConfig' => [
                        'temperature'     => 0.7,
                        'maxOutputTokens' => 1024,
                    ],
                ]);

            if ($response->successful()) {
                $answer = $response->json('candidates.0.content.parts.0.text') ?? 'AI did not return a response.';
            } else {
                $errMsg = $response->json('error.message') ?? 'Unknown error';
                $answer = "AI Error: {$errMsg}";
            }
        } catch (\Exception $e) {
            $answer = 'Connection error: ' . $e->getMessage();
        }

        return back()
            ->with('ai_answer', $answer)
            ->with('ai_question', $question);
    }
}
