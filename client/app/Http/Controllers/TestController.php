<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\TestAnswer;
use App\Models\FacialExpression;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function create()
    {
        $questions = $this->getQuestions();
        return view('test.form', compact('questions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'college' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'contact_number' => 'required|string|max:20',
            'sex' => 'required|string|in:male,female,other',
            'email' => 'required|email|max:255',
            'answers' => 'required|array',
            'answers.*' => 'required|integer|min:0|max:3',
            'medical_history' => 'nullable|array',
            'medical_history.*' => 'string'
        ]);

        // Calculate total score
        $totalScore = array_sum($request->answers);
        
        // Determine depression level
        $depressionLevel = $this->determineDepressionLevel($totalScore);

        // Create test record
        $test = Test::create([
            'user_id' => Auth::id(),
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'college' => $validated['college'],
            'course' => $validated['course'],
            'age' => $validated['age'],
            'contact_number' => $validated['contact_number'],
            'sex' => $validated['sex'],
            'email' => $validated['email'],
            'total_score' => $totalScore,
            'depression_level' => $depressionLevel,
            'medical_history' => implode(', ', $validated['medical_history'])
        ]);

        // Store answers
        foreach ($request->answers as $questionId => $answer) {
            TestAnswer::create([
                'test_id' => $test->id,
                'question_id' => $questionId,
                'answer' => $answer
            ]);
        }

        // Notify Python service about the new test ID
        try {
            Http::post('http://localhost:5000/set_test_id', [
                'test_id' => $test->id
            ]);

            // Get expressions from Python service
            $response = Http::get('http://localhost:5000/get_expressions');
            if ($response->successful()) {
                $expressions = json_decode($response->body(), true);
                foreach ($expressions as $expression) {
                    FacialExpression::create([
                        'test_id' => $test->id,
                        'emotion' => $expression['emotion'],
                        'confidence' => $expression['confidence'],
                        'timestamp' => $expression['timestamp']
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to communicate with Python service: ' . $e->getMessage());
        }

        return redirect()->route('test.show', $test)->with('success', 'Test submitted successfully!');
    }

    public function show(Test $test)
    {
        $test->load(['answers', 'facialExpressions']);
        $questions = $this->getQuestions();
        
        return view('test.show', compact('test', 'questions'));
    }

    private function determineDepressionLevel($score)
    {
        if ($score <= 10) {
            return 'Normal';
        } elseif ($score <= 16) {
            return 'Mild';
        } elseif ($score <= 20) {
            return 'Moderate';
        } elseif ($score <= 30) {
            return 'Severe';
        } else {
            return 'Extremely Severe';
        }
    }

    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'text' => 'I do not feel sad.',
                'options' => [
                    ['value' => 0, 'text' => 'I do not feel sad.'],
                    ['value' => 1, 'text' => 'I feel sad'],
                    ['value' => 2, 'text' => 'I am sad all the time and I can\'t snap out of it.'],
                    ['value' => 3, 'text' => 'I am so sad and unhappy that I can\'t stand it.']
                ]
            ],
            // ... rest of the questions ...
        ];
    }
} 