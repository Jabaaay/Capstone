<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;

class AdminController extends Controller
{

    public function dashboard()
    {
        $totalTests = Test::count();
        $totalUsers = User::count();
        $recentTests = Test::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalTests', 'totalUsers', 'recentTests'));
    }

    public function tests()
    {
        $tests = Test::with('user')->latest()->paginate(10);
        return view('admin.tests', compact('tests'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function showTest(Test $test)
    {
        $test->load('answers');
        $questions = $this->getQuestions();
        
        return view('admin.test-details', compact('test', 'questions'));
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
            [
                'id' => 2,
                'text' => 'I am not particularly discouraged about the future.',
                'options' => [
                    ['value' => 0, 'text' => 'I am not particularly discouraged about the future.'],
                    ['value' => 1, 'text' => 'I feel discouraged about the future.'],
                    ['value' => 2, 'text' => 'I feel I have nothing to look forward to.'],
                    ['value' => 3, 'text' => 'I feel the future is hopeless and that things cannot improve.']
                ]
            ],
            [
                'id' => 3,
                'text' => 'I do not feel like a failure.',
                'options' => [
                    ['value' => 0, 'text' => 'I do not feel like a failure.'],
                    ['value' => 1, 'text' => 'I feel I have failed more than the average person.'],
                    ['value' => 2, 'text' => 'As I look back on my life, all I can see is a lot of failures.'],
                    ['value' => 3, 'text' => 'I feel I am a complete failure as a person.']
                ]
            ],
            [
                'id' => 4,
                'text' => 'I get as much satisfaction out of things as I used to.',
                'options' => [
                    ['value' => 0, 'text' => 'I get as much satisfaction out of things as I used to.'],
                    ['value' => 1, 'text' => 'I don\'t enjoy things the way I used to.'],
                    ['value' => 2, 'text' => 'I don\'t get real satisfaction out of anything anymore.'],
                    ['value' => 3, 'text' => 'I am dissatisfied or bored with everything.']
                ]
            ],
            [
                'id' => 5,
                'text' => 'I don\'t feel particularly guilty',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel particularly guilty'],
                    ['value' => 1, 'text' => 'I feel guilty a good part of the time.'],
                    ['value' => 2, 'text' => 'I feel quite guilty most of the time.'],
                    ['value' => 3, 'text' => 'I feel guilty all of the time.']
                ]
            ],
            [
                'id' => 6,
                'text' => 'I don\'t feel I am being punished.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel I am being punished.'],
                    ['value' => 1, 'text' => 'I feel I may be punished.'],
                    ['value' => 2, 'text' => 'I expect to be punished.'],
                    ['value' => 3, 'text' => 'I feel I am being punished.']
                ]
            ],
            [
                'id' => 7,
                'text' => 'I don\'t feel disappointed in myself.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel disappointed in myself.'],
                    ['value' => 1, 'text' => 'I am disappointed in myself.'],
                    ['value' => 2, 'text' => 'I am disgusted with myself.'],
                    ['value' => 3, 'text' => 'I hate myself.']
                ]
            ],
            [
                'id' => 8,
                'text' => 'I don\'t feel I am any worse than anybody else.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel I am any worse than anybody else.'],
                    ['value' => 1, 'text' => 'I am critical of myself for my weaknesses or mistakes.'],
                    ['value' => 2, 'text' => 'I blame myself all the time for my faults.'],
                    ['value' => 3, 'text' => 'I blame myself for everything bad that happens.']
                ]
            ],
            [
                'id' => 9,
                'text' => 'I don\'t have any thoughts of killing myself.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t have any thoughts of killing myself.'],
                    ['value' => 1, 'text' => 'I have thoughts of killing myself, but I would not carry them out.'],
                    ['value' => 2, 'text' => 'I would like to kill myself.'],
                    ['value' => 3, 'text' => 'I would kill myself if I had the chance.']
                ]
            ],
            [
                'id' => 10,
                'text' => 'I don\'t cry any more than usual.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t cry any more than usual.'],
                    ['value' => 1, 'text' => 'I cry more now than I used to.'],
                    ['value' => 2, 'text' => 'I cry all the time now.'],
                    ['value' => 3, 'text' => 'I used to be able to cry, but now I can\'t cry even though I want to.']
                ]
            ],
            [
                'id' => 11,
                'text' => 'I am no more irritated by things than I ever was.',
                'options' => [
                    ['value' => 0, 'text' => 'I am no more irritated by things than I ever was.'],
                    ['value' => 1, 'text' => 'I am slightly more irritated now than usual.'],
                    ['value' => 2, 'text' => 'I am quite annoyed or irritated a good deal of the time.'],
                    ['value' => 3, 'text' => 'I feel irritated all the time.']
                ]
            ],
            [
                'id' => 12,
                'text' => 'I have not lost interest in other people.',
                'options' => [
                    ['value' => 0, 'text' => 'I have not lost interest in other people.'],
                    ['value' => 1, 'text' => 'I am less interested in other people than I used to be.'],
                    ['value' => 2, 'text' => 'I have lost most of my interest in other people.'],
                    ['value' => 3, 'text' => 'I have lost all of my interest in other people.']
                ]
            ],
            [
                'id' => 13,
                'text' => 'I make decisions about as well as I ever could.',
                'options' => [
                    ['value' => 0, 'text' => 'I make decisions about as well as I ever could.'],
                    ['value' => 1, 'text' => 'I put off making decisions more than I used to.'],
                    ['value' => 2, 'text' => 'I have greater difficulty in making decisions more than I used to.'],
                    ['value' => 3, 'text' => 'I can\'t make decisions at all anymore.']
                ]
            ],
            [
                'id' => 14,
                'text' => 'I don\'t feel that I look any worse than I used to.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t feel that I look any worse than I used to.'],
                    ['value' => 1, 'text' => 'I am worried that I am looking old or unattractive.'],
                    ['value' => 2, 'text' => 'I feel there are permanent changes in my appearance that make me look unattractive'],
                    ['value' => 3, 'text' => 'I believe that I look ugly.']
                ]
            ],
            [
                'id' => 15,
                'text' => 'I can work about as well as before.',
                'options' => [
                    ['value' => 0, 'text' => 'I can work about as well as before.'],
                    ['value' => 1, 'text' => 'It takes an extra effort to get started at doing something.'],
                    ['value' => 2, 'text' => 'I have to push myself very hard to do anything.'],
                    ['value' => 3, 'text' => 'I can\'t do any work at all.']
                ]
            ],
            [
                'id' => 16,
                'text' => 'I can sleep as well as usual.',
                'options' => [
                    ['value' => 0, 'text' => 'I can sleep as well as usual.'],
                    ['value' => 1, 'text' => 'I don\'t sleep as well as I used to.'],
                    ['value' => 2, 'text' => 'I wake up 1-2 hours earlier than usual and find it hard to get back to sleep.'],
                    ['value' => 3, 'text' => 'I wake up several hours earlier than I used to and cannot get back to sleep.']
                ]
            ],
            [
                'id' => 17,
                'text' => 'I don\'t get more tired than usual.',
                'options' => [
                    ['value' => 0, 'text' => 'I don\'t get more tired than usual.'],
                    ['value' => 1, 'text' => 'I get tired more easily than I used to.'],
                    ['value' => 2, 'text' => 'I get tired from doing almost anything.'],
                    ['value' => 3, 'text' => 'I am too tired to do anything.']
                ]
            ],
            [
                'id' => 18,
                'text' => 'My appetite is no worse than usual.',
                'options' => [
                    ['value' => 0, 'text' => 'My appetite is no worse than usual.'],
                    ['value' => 1, 'text' => 'My appetite is not as good as it used to be.'],
                    ['value' => 2, 'text' => 'My appetite is much worse now.'],
                    ['value' => 3, 'text' => 'I have no appetite at all anymore.']
                ]
            ],
            [
                'id' => 19,
                'text' => 'I haven\'t lost much weight, if any, lately.',
                'options' => [
                    ['value' => 0, 'text' => 'I haven\'t lost much weight, if any, lately.'],
                    ['value' => 1, 'text' => 'I have lost more than five pounds.'],
                    ['value' => 2, 'text' => 'I have lost more than ten pounds.'],
                    ['value' => 3, 'text' => 'I have lost more than fifteen pounds.']
                ]
            ],
            [
                'id' => 20,
                'text' => 'I am no more worried about my health than usual.',
                'options' => [
                    ['value' => 0, 'text' => 'I am no more worried about my health than usual.'],
                    ['value' => 1, 'text' => 'I am worried about physical problems like aches, pains, upset stomach, or constipation.'],
                    ['value' => 2, 'text' => 'I am very worried about physical problems and it\'s hard to think of much else.'],
                    ['value' => 3, 'text' => 'I am so worried about my physical problems that I cannot think of anything else.']
                ]
            ],
            [
                'id' => 21,
                'text' => 'I have not noticed any recent change in my interest in sex.',
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