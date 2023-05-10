<?php

    namespace App\Http\Controllers;

    use App\Models\ResultParameter;
    use App\Models\Results;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;

    class AnswersController extends BaseController
    {
        use ValidatesRequests;

        public function storeAnswer(Request $request)
        {
            if($request['items']){
                $items = json_decode($request['items']);
                // Use count instead user id, we don't have user interface
                $count = Results::all()->last();

                $resultIds = [];

                $num = 1;
                if($count)
                    $num = $count->key + $num;

                if(!$count){
                    foreach($items as $result){
                        $resultModel = new Results();
                        $resultModel->key = $num;
                        $resultModel->question_id = $result->question_id;
                        $resultModel->answer_id = $result->answer_id;
                        $resultModel->save();
                    }
                } else{
                    foreach($items as $result){
                        $resultModel = new Results();
                        $resultModel->key = $num;
                        $resultModel->question_id = $result->question_id;
                        $resultModel->answer_id = $result->answer_id;
                        $resultModel->save();
                    }
                }

                $data = Results::where(['key' => $num])->get();
                foreach($data as $result){
                    array_push($resultIds, $result->answers->parameter->id);
                };

                // new array containing frequency of values of $arr
                $arr_freq = array_count_values($resultIds);
                // arranging the new $arr_freq in decreasing order
                // of occurrences
                arsort($arr_freq);
                // $new_arr containing the keys of sorted array
                $new_arr = array_keys($arr_freq);

                return view('results', ['result' => ResultParameter::find($new_arr[0])]);
            } else {
              return redirect('/');
            }
        }

        public function getAnswers()
        {
            return view('answers', ['items' => Results::all()]);
        }

        public function getAnswer($id)
        {
            return view('answer', ['answer' => Results::where('key','=',$id)->get()]);
        }

    }
