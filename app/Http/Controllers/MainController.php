<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    private $app_data;

    public function __construct()
    {
        $this->app_data = require(app_path('app_data.php'));
    }

   public function startGame(): View
   {
        return view('home');
   }

   public function prepareGame(Request $request){
        $request->validate(
            [
                'total_questions' => 'required|integer|min:3|max:30'
            ],
            [
                'total_questions.required' => 'NÚMERO DE QUESTÕES É OBRIGATÓRIO',
                'total_questions.integer' => 'DEVE SER UM NÚMERO INTEIRO',
                'total_questions.min' => 'NÚMERO DE QUESTÕES MÍNIMO É :min',
                'total_questions.max' => 'NÚMERO DE QUESTÕES MÁXIMO É :max'
            ]
        );

        $total_questions = intval($request->input('total_questions'));

        $quiz = $this->prepareQuiz($total_questions);

        dd($quiz);
   }

   private function prepareQuiz($total_questions){

        $questions = [];
        $total_countries = count($this->app_data) - 1;

        $indexes = range(0, $total_countries);
        shuffle($indexes);
        $indexes = array_slice($indexes, 0, $total_questions);

        $question_number = 1;
        foreach($indexes as $index){
            $question['question_number'] = $question_number++;
            $question['country'] = $this->app_data[$index]['country'];
            $question['correct_answer'] = $this->app_data[$index]['capital'];

            $other_capitals = array_column($this->app_data, 'capital');

            $other_capitals = array_diff($other_capitals, [$question['correct_answer']]); 

            shuffle($other_capitals);
            $question['wrong_answer'] = array_slice($other_capitals, 0, 3);

            $question['correct'] = null;
            $questions[] = $question;
        }

       return $questions;
   }
}
