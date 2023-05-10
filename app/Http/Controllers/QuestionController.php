<?php

    namespace App\Http\Controllers;

    use App\Models\Answer;
    use App\Models\Question;
    use App\Models\ResultParameter;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;

    class QuestionController extends BaseController
    {
        use ValidatesRequests;

        public function addQuestionForm()
        {
            return view('addQuestion', ['result_parameters' => ResultParameter::all()]);
        }

        public function store(Request $request)
        {
            $validatedData = $request->validate([
                'question' => 'required|string|max:255',
                'answers.*' => 'nullable|string|max:255',
                'result_answer.*' => 'nullable|integer|exists:result_parameters,id',
            ]);

            $question = new Question();
            $question->question = $validatedData['question'];
            $question->save();

            if($validatedData['answers']){
                foreach($validatedData['answers'] as $key => $answer)
                {
                    if($answer) {
                        $answerModel = new Answer();
                        $answerModel->answer = $answer;
                        $answerModel->question_id = $question->id;
                        $answerModel->result_id = $validatedData['result_answer'][$key];
                        $answerModel->save();
                    }
                }
            }

            return redirect('/questions');
        }

        public function delete(Request $request, $id)
        {
            // Delete the questions and the answers if they are attached to the questions
            $record = Question::find($id);
            $record->delete();
            Answer::where('question_id', $id)->delete();

            return redirect('/questions');
        }

        public function updateOut($id)
        {
            return view("update", ['question' => Question::find($id), 'result_parameters' => ResultParameter::all()]);
        }

        public function update(Request $request, $id)
        {
            $question = Question::findOrFail($id);
            $question->question = $request->input('question');
            $question->save();

            $answers = $request->input('answers');
            foreach ($question->answers as $answer) {
                $answer->delete();
            }

            foreach($answers as $key => $answer_item)
            {
                $answer = new Answer();
                $answer->answer = $answer_item;
                $answer->question_id = $id;
                $answer->result_id = $request['result_answer'][$key];
                $answer->save();
            }

            return redirect('/questions');
        }

    }
