<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;
use DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\FacialExpression;

class AdminController extends Controller
{

    public function dashboard()
    {
        $totalTests = Test::count();
        $totalUsers = User::where('is_admin', 0)->count();
        $diagnosedCount = Test::where('depression_level', 'Extreme depression') ->orWhere('depression_level', 'Severe depression') ->orWhere('depression_level', 'Moderate depression') ->orWhere('depression_level', 'Mild mood disturbance')->count();
        $notDiagnosedCount = Test::where('depression_level', 'Normal')->count();
        $recentTests = Test::with('user')->latest()->take(1)->get();

        $normalCount = Test::where('depression_level', 'Normal')->count();
        $mildCount = Test::where('depression_level', 'Mild mood disturbance')->count();
        $borderlineCount = Test::where('depression_level', 'Borderline depression')->count();
        $moderateCount = Test::where('depression_level', 'Moderate depression')->count();
        $severeCount = Test::where('depression_level', 'Severe depression')->count();
        $extremeCount = Test::where('depression_level', 'Extreme depression')->count();

        $mostFrequentExpression = FacialExpression::select('expression', DB::raw('COUNT(*) as count'))
            ->groupBy('expression')
            ->orderBy('count', 'desc')
            ->first();
        

        // Get test data for the area chart
        $testData = Test::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('total_score as score')
        )
        ->orderBy('date')
        ->get();

        $testDates = $testData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('M d');
        })->toArray();

        $testScores = $testData->pluck('score')->toArray();

        return view('admin.dashboard', compact('totalTests', 'totalUsers', 'recentTests', 'diagnosedCount', 'notDiagnosedCount', 'testDates', 'testScores', 'normalCount', 'mildCount', 'moderateCount', 'severeCount', 'extremeCount', 'borderlineCount'));
    }

    public function tests()
    {
        $tests = Test::with('user')->latest()->paginate();
        return view('admin.tests', compact('tests'));
    }

    public function users()
    {
        $users = User::where('is_admin', 0)->latest()->paginate();
        return view('admin.users', compact('users'));
    }

    public function showTest(Test $test)
    {
        $test->load(['answers', 'facialExpressions']);
        $questions = $this->getQuestions();
        
        return view('admin.test-details', compact('test', 'questions'));
    }

    public function videoFeed()
    {
        return view('admin.video-feed');
    }

    public function downloadPdf(Test $test)
    {
        $test->load(['answers', 'facialExpressions']);
        $questions = $this->getQuestions();
        
        $pdf = PDF::loadView('admin.test-pdf', compact('test', 'questions'));
        
        return $pdf->download('test-results-' . $test->id . '.pdf');
    }

    private function getQuestions()
    {
        return 
        [
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
    }
} 