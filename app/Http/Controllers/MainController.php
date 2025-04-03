<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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

    public function prepareGame(Request $request)
    {
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

        session()->put([
            'quiz' => $quiz,
            'total_questions' => $total_questions,
            'current_question' => 1,
            'correct_answers' =>  0,
            'wrong_answers' =>  0,
        ]);

        return redirect()->route('game');
    }

    public function game(): View
    {
        $quiz = session('quiz');
        $total_questions = session('total_questions');
        $current_question = session('current_question') - 1;

        $answers = $quiz[$current_question]['wrong_answers'];
        $answers[] = $quiz[$current_question]['correct_answer'];

        shuffle($answers);

        $gameQuestions = [
            'country' => $quiz[$current_question]['country'],
            'totalQuestions' => $total_questions,
            'currentQuestion' => ++$current_question,
            'answers' => $answers,
        ];

        return view('game')->with($gameQuestions);
    }

    public function sendAnswer($encryptedAnswer)
    {

        try {

            $answer = Crypt::decryptString($encryptedAnswer);

            $quiz = session("quiz");
            $currentQuestion = session("current_question") - 1;
            $wrongAnswers = session("wrong_answers");
            $correctAnswers = session("correct_answers");
            $correctAnswer = $quiz[$currentQuestion]['correct_answer'];

            if ($correctAnswer == $answer) {
                $correctAnswers++;
                $quiz[$currentQuestion]["correct"] = true;
            } else {
                $wrongAnswers++;
                $quiz[$currentQuestion]["correct"] = false;
            }

            session()->put([
                "quiz" => $quiz,
                "correct_answers" => $correctAnswers,
                "wrong_answers" => $wrongAnswers
            ]);

            $data = [
                'country' => $quiz[$currentQuestion]['country'],
                'currentQuestion' => ++$currentQuestion,
                'correctAnswer' => $correctAnswer,
                'choiceAnswer' => $answer,
                'totalQuestions' => session("total_questions"),
            ];

            return view("answer_result", $data);
        } catch (Exception $e) {
            return redirect()->route('game');
        }
    }

    public function nextQuestion(){
        $totalQuestions = session("total_questions");
        $currentQuestion = session("current_question");

        if($currentQuestion >= $totalQuestions) {
            
            return redirect()->route("result");
        }

        $currentQuestion++;
        session()->put([
            "current_question" => $currentQuestion
        ]);
        return redirect()->route("game");
    }

    public function showResult(){
        echo "issai";
        dd(session()->all());
    }

    private function prepareQuiz($total_questions)
    {

        $questions = [];
        $total_countries = count($this->app_data);

        $indexes = range(0, $total_countries - 1);
        shuffle($indexes);
        $indexes = array_slice($indexes, 0, $total_questions);

        foreach ($indexes as $question_number => $index) {
            $questions[] = $this->prepareQuestions($question_number, $index);
        }

        return $questions;
    }

    private function prepareQuestions($question_number, $country_index): array
    {
        $question['question_number'] = $question_number++;
        $question['country'] = $this->app_data[$country_index]['country'];
        $question['correct_answer'] = $this->app_data[$country_index]['capital'];
        $question['correct'] = null;

        $other_capitals = array_column($this->app_data, 'capital');
        $other_capitals = array_diff($other_capitals, [$question['correct_answer']]);
        shuffle($other_capitals);

        $question['wrong_answers'] = array_slice($other_capitals, 0, 3);



        return $question;
    }
}
