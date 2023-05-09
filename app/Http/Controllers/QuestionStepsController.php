<?php

    namespace App\Http\Controllers;

    use App\Models\Question;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Routing\Controller as BaseController;

    class QuestionStepsController extends BaseController
    {
        use ValidatesRequests;

        /**
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
         */
        public function getSteps()
        {
            return view('pull',[ 'questions' => Question::all() ]);
        }

        public function getQuestions()
        {
            return view('questions', ['allQuestions' => Question::all()]);
        }
    }
