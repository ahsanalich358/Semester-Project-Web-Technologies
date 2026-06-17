<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function index()
    {
        return view('student.ai');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $settings = Setting::getSettings();

        if (!$settings->gemini_api_key) {
            return response()->json([
                'error' => 'AI Assistant is not configured. Please contact admin to set up the Gemini API key.'
            ], 503);
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$settings->gemini_api_key}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => "You are a helpful learning assistant for students. Answer clearly and educationally.\n\nStudent question: " . $request->question
                                ]
                            ]
                        ]
                    ]
                ]
            );

            if ($response->failed()) {
                return response()->json(['error' => 'AI service returned an error. Please try again.'], 500);
            }

            $data   = $response->json();
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response received.';

            return response()->json(['answer' => $answer]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reach AI service. Please try again.'], 500);
        }
    }
}
