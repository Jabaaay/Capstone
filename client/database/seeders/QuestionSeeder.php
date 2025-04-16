<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            ['question_text' => 'I feel sad or depressed', 'category' => 'mood', 'order' => 1],
            ['question_text' => 'I feel hopeless about the future', 'category' => 'mood', 'order' => 2],
            ['question_text' => 'I feel like a failure', 'category' => 'self-esteem', 'order' => 3],
            ['question_text' => 'I don\'t enjoy things as much as I used to', 'category' => 'anhedonia', 'order' => 4],
            ['question_text' => 'I feel guilty', 'category' => 'mood', 'order' => 5],
            ['question_text' => 'I feel like I\'m being punished', 'category' => 'mood', 'order' => 6],
            ['question_text' => 'I feel disappointed in myself', 'category' => 'self-esteem', 'order' => 7],
            ['question_text' => 'I feel critical of myself', 'category' => 'self-esteem', 'order' => 8],
            ['question_text' => 'I have thoughts of killing myself', 'category' => 'suicidal', 'order' => 9],
            ['question_text' => 'I cry more than usual', 'category' => 'mood', 'order' => 10],
            ['question_text' => 'I am more irritable than usual', 'category' => 'mood', 'order' => 11],
            ['question_text' => 'I have lost interest in other people', 'category' => 'social', 'order' => 12],
            ['question_text' => 'I have trouble making decisions', 'category' => 'cognitive', 'order' => 13],
            ['question_text' => 'I feel unattractive', 'category' => 'self-esteem', 'order' => 14],
            ['question_text' => 'I have trouble working', 'category' => 'functioning', 'order' => 15],
            ['question_text' => 'I have trouble sleeping', 'category' => 'sleep', 'order' => 16],
            ['question_text' => 'I get tired for no reason', 'category' => 'physical', 'order' => 17],
            ['question_text' => 'I have no appetite', 'category' => 'physical', 'order' => 18],
            ['question_text' => 'I have lost weight', 'category' => 'physical', 'order' => 19],
            ['question_text' => 'I am worried about my health', 'category' => 'physical', 'order' => 20],
            ['question_text' => 'I have lost interest in sex', 'category' => 'physical', 'order' => 21],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
} 