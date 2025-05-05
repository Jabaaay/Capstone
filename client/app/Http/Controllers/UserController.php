<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\TestAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function testForm()
    {
        return view('user.test-form');
    }

    public function submitTest(Request $request)
    {
        $validated = $request->validate([
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'college' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'birthday' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'sex' => 'required|in:male,female,other',
            'email' => Auth::user()->email,
            'terms_accepted' => 'required|accepted',
            'medical_history' => 'nullable|array',
            'medical_history.*' => 'string'
        ]);
        $medicalHistory = $request->input('medical_history', []);

    if (in_array('Others', $medicalHistory) && !empty($request->input('other_medical_history'))) {
        $medicalHistory = array_filter($medicalHistory, fn($item) => $item !== 'Others');
        $medicalHistory[] = 'Others: ' . $request->input('other_medical_history');
    }

    $medicalHistoryStr = implode(', ', $medicalHistory);

        // Create the test record first
        $test = Test::create([
            'user_id' => auth()->id(),
            'first_name' => Auth::user()->first_name,
            'last_name' => Auth::user()->last_name,
            'college' => $validated['college'],
            'course' => $validated['course'],
            'age' => $validated['age'],
            'birthday' => $validated['birthday'],
            'contact_number' => $validated['contact_number'],
            'sex' => $validated['sex'],
            'email' => Auth::user()->email,
            'total_score' => 0,
            'depression_level' => 'Pending',
            'medical_history' => $medicalHistoryStr
        ]);

        // Store the test information in session
        session(['test_info' => $validated]);
        session(['test_id' => $test->id]);

        // Set the test ID and user ID in the Python service
        try {
            Http::post('http://localhost:5000/set_test_info', [
                'test_id' => $test->id,
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to set test info in Python service: ' . $e->getMessage());
        }

        // Start video
        try {
            Http::post('http://localhost:5000/start_video');
        } catch (\Exception $e) {
            \Log::error('Failed to start video: ' . $e->getMessage());
        }

        return redirect()->route('user.test.questions');
    }

    public function testQuestions()
    {
        if (!session()->has('test_info')) {
            return redirect()->route('user.test.form');
        }

        $questions = [
            [
                'id' => 1,
                'text' => 'Sadness',
                'options' => [
                    ['value' => 0, 'text' => 'I do not feel sad.'],
                    ['value' => 1, 'text' => 'I feel sad much of the time.'],
                    ['value' => 2, 'text' => 'I am sad all the time.'],
                    ['value' => 3, 'text' => 'I am so sad and unhappy that I can\'t stand it.']
                ]
            ],
            [
                'id' => 2,
                'text' => 'Pessimism',
                'options' => [
                    ['value' => 0, 'text' => 'I am not discouraged about my future.'],
                    ['value' => 1, 'text' => 'I feel more discouraged about my future than I used to.'],
                    ['value' => 2, 'text' => 'I do not expect things to work out for me.'],
                    ['value' => 3, 'text' => 'I feel my future is hopeless and will only get worse.']
                ]
            ],
            [
                'id' => 3,
                'text' => 'Past Failure',
                'options' => [
                    ['value' => 0, 'text' => 'I do not feel like a failure.'],
                    ['value' => 1, 'text' => 'I have failed more than I should have.'],
                    ['value' => 2, 'text' => 'As I look back, I see a lot of failures.'],
                    ['value' => 3, 'text' => 'I feel I am a total failure as a person.']
                ]
            ],
            [
                'id' => 4,
                'text' => 'Loss of Pleasure',
                'options' => [
                    ['value' => 0, 'text' => 'I get as much pleasure as i ever did from the things I used to enjoy.'],
                    ['value' => 1, 'text' => 'I don\'t enjoy things as much as I used to.'],
                    ['value' => 2, 'text' => 'I get very little pleasure from the things I used to enjoy.'],
                    ['value' => 3, 'text' => 'I can\'t get any pleasure from the things I used to enjoy.']
                ]
            ],
            [
                'id' => 5,
                'text' => 'Guilty Feelings',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel particularly guilty'],
                    ['value' => 1, 'text' => 'I feel guilty over many things I have done or should have done.'],
                    ['value' => 2, 'text' => 'I feel quite guilty most of the time.'],
                    ['value' => 3, 'text' => 'I feel guilty all of the time.']
                ]
            ],
            [
                'id' => 6,
                'text' => 'Punishment Feelings',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel I am being punished.'],
                    ['value' => 1, 'text' => 'I feel I may be punished.'],
                    ['value' => 2, 'text' => 'I expect to be punished.'],
                    ['value' => 3, 'text' => 'I feel I am being punished.']
                ]
            ],
            [
                'id' => 7,
                'text' => 'Self-Dislike',
                'options' => [
                    ['value' => 0, 'text' => 'I feel the same about myself as ever.'],
                    ['value' => 1, 'text' => 'I have lost confidence in myself.'],
                    ['value' => 2, 'text' => 'I am dissapointed with myself.'],
                    ['value' => 3, 'text' => 'I dislike myself.']
                ]
            ],
            [
                'id' => 8,
                'text' => 'Self-Criticalness',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t criticize or blame myself more than usual.'],
                    ['value' => 1, 'text' => 'I am more critical of myself than I used to be.'],
                    ['value' => 2, 'text' => 'I criticize myself for all of my faults.'],
                    ['value' => 3, 'text' => 'I blame myself for everything bad that happens.']
                ]
            ],
            [
                'id' => 9,
                'text' => 'Suicidal Thoughts or Wishes',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t have any thoughts of killing myself.'],
                    ['value' => 1, 'text' => 'I have thoughts of killing myself, but I would not carry them out.'],
                    ['value' => 2, 'text' => 'I would like to kill myself.'],
                    ['value' => 3, 'text' => 'I would kill myself if I had the chance.']
                ]
            ],
            [
                'id' => 10,
                'text' => 'Crying',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t cry anymore than I used to.'],
                    ['value' => 1, 'text' => 'I cry more than I used to.'],
                    ['value' => 2, 'text' => 'I cry over every little thing.'],
                    ['value' => 3, 'text' => 'I feel like crying, but I can\'t.']
                ]
            ],
            [
                'id' => 11,
                'text' => 'Agitation',
                'options' => [
                    ['value' => 0, 'text' => 'I am no more restless or wound up than usual.'],
                    ['value' => 1, 'text' => 'I feel more restless or wound up than usual'],
                    ['value' => 2, 'text' => 'I am so restless or agitated, it\'s hard to stay still.'],
                    ['value' => 3, 'text' => 'I am so restless or agitated that I have to keep moving or doing something.']
                ]
            ],
            [
                'id' => 12,
                'text' => 'Loss of Interest',
                'options' => [
                    ['value' => 0, 'text' => 'I have not lost interest in other people or activities.'],
                    ['value' => 1, 'text' => 'I am less interested in other people or things than before.'],
                    ['value' => 2, 'text' => 'I have lost most of my interest in other people or things.'],
                    ['value' => 3, 'text' => 'It\'s hard to get interested in anything.']
                ]
            ],
            [
                'id' => 13,
                'text' => 'Indecisiveness',
                'options' => [
                    ['value' => 0, 'text' => 'I make decisions about as well as ever'],
                    ['value' => 1, 'text' => 'I find it more difficult to make decisions than usual.'],
                    ['value' => 2, 'text' => 'I have much greater difficulty in making decisions than I used to.'],
                    ['value' => 3, 'text' => 'I have trouble making any decisions.']
                ]
            ],
            [
                'id' => 14,
                'text' => 'Worthlessness',
                'options' => [
                    ['value' => 0, 'text' => 'I do not feel that I am worthless.'],
                    ['value' => 1, 'text' => 'I don\'t consider myself as worthwhile and useful as i used to.'],
                    ['value' => 2, 'text' => 'I fell more worthless as compared to others.'],
                    ['value' => 3, 'text' => 'i feel utterly worthless.']
                ]
            ],
            [
                'id' => 15,
                'text' => 'Loss of Energy',
                'options' => [
                    ['value' => 0, 'text' => 'I have as much energy as ever.'],
                    ['value' => 1, 'text' => 'I have less energy than I used to have.'],
                    ['value' => 2, 'text' => 'I don\'t have enough energy to do very much.'],
                    ['value' => 3, 'text' => 'I don\'t have energy to do anything.']
                ]
            ],
            [
                'id' => 16,
                'text' => 'Changes in Sleeping Patterns',
                'options' => [
                    ['value' => 0, 'text' => 'I have not experienced any change in my sleeping.'],
                    ['value' => 1, 'text' => 'I sleep somewhat more than usual.'],
                    ['value' => 2, 'text' => 'I sleep a lot more than usual.'],
                    ['value' => 3, 'text' => 'I sleep most of the day.']
                ]
            ],
            [
                'id' => 17,
                'text' => 'Irritability',
                'options' => [
                    ['value' => 0, 'text' => 'I am not more irritable than usual.'],
                    ['value' => 1, 'text' => 'I am more irritable than usual.'],
                    ['value' => 2, 'text' => 'I am much more irritable than usual.'],
                    ['value' => 3, 'text' => 'I am irritable all the time.']
                ]
            ],
            [
                'id' => 18,
                'text' => 'Changes in Appetite',
                'options' => [
                    ['value' => 0, 'text' => 'I have not experienced any change in my appetite.'],
                    ['value' => 1, 'text' => 'My appetite is somewhat less than usual.'],
                    ['value' => 2, 'text' => 'My appetite is much less than before.'],
                    ['value' => 3, 'text' => 'I have no appetite at all.']
                ]
            ],
            [
                'id' => 19,
                'text' => 'Concentration Difficulties',
                'options' => [
                    ['value' => 0, 'text' => 'I can concentrate as well as ever.'],
                    ['value' => 1, 'text' => 'I can\'t concentrate as well as usual.'],
                    ['value' => 2, 'text' => 'It\'s hard to keep my mind on anything for very long.'],
                    ['value' => 3, 'text' => 'I find i can\'t concentrate on anything.']
                ]
            ],
            [
                'id' => 20,
                'text' => 'Tiredness and Fatigue',
                'options' => [
                    ['value' => 0, 'text' => 'I am no more tired or fatigued than usual.'],
                    ['value' => 1, 'text' => 'I get more tired or fatigued more easily than usual.'],
                    ['value' => 2, 'text' => 'I am too tired or fatigued to do a lot of the things I used to do.'],
                    ['value' => 3, 'text' => 'I am too tired or fatigued to do most of the things I used to do.']
                ]
            ],
            [
                'id' => 21,
                'text' => 'Loss of Interest in Sex',
                'options' => [
                    ['value' => 0, 'text' => 'I have not noticed any recent change in my interest in sex.'],
                    ['value' => 1, 'text' => 'I am less interested in sex than I used to be.'],
                    ['value' => 2, 'text' => 'I have almost no interest in sex.'],
                    ['value' => 3, 'text' => 'I have lost interest in sex completely.']
                    
                ]
            ]
        ];

        return view('user.test-questions', compact('questions'));
    }

    public function submitAnswers(Request $request)
    {
        if (!session()->has('test_info') || !session()->has('test_id')) {
            return redirect()->route('user.test.form');
        }

        $validated = $request->validate([
            'answers' => 'required|array|size:21',
            'answers.*' => 'required|integer|min:0|max:3'
        ]);

        $totalScore = array_sum($validated['answers']);
        
        // Determine the depression level based on the total score
        $depressionLevel = $this->determineDepressionLevel($totalScore);

        // Get the test record
        $test = Test::findOrFail(session('test_id'));

        // Update the test results
        $test->update([
            'total_score' => $totalScore,
            'depression_level' => $depressionLevel
        ]);

        // Store individual answers
        foreach ($validated['answers'] as $questionId => $answer) {
            TestAnswer::create([
                'test_id' => $test->id,
                'question_id' => $questionId,
                'answer' => $answer
            ]);
        }

        // Stop video
        try {
            Http::post('http://localhost:5000/stop_video');
        } catch (\Exception $e) {
            \Log::error('Failed to stop video: ' . $e->getMessage());
        }

        // Clear the session
        session()->forget(['test_info', 'test_id']);

        return view('user.test-results', compact('totalScore', 'depressionLevel'));
    }

    private function determineDepressionLevel($score)
    {
        if ($score <= 10) {
            return 'Normal';
        } elseif ($score <= 16) {
            return 'Mild mood disturbance';
        } elseif ($score <= 20) {
            return 'Borderline clinical depression';
        } elseif ($score <= 30) {
            return 'Moderate depression';
        } elseif ($score <= 40) {
            return 'Severe depression';
        } else {
            return 'Extreme depression';
        }
    }
} 