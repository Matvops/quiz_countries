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

   private function prepareQuiz($questions){

        return null;
   }
}
