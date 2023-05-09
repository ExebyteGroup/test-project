<?php

    namespace App\Http\Controllers;

    use App\Models\Answer;
    use App\Models\Question;
    use App\Models\ResultParameter;
    use Illuminate\Foundation\Validation\ValidatesRequests;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller as BaseController;

    class ResultParameterController extends BaseController
    {
        use ValidatesRequests;

        public function resultView()
        {
            return view('result/resultView', ['result_parameters' => ResultParameter::all()]);
        }

        public function createResultParameter()
        {
            return view('result/addParameter');
        }

        public function store(Request $request)
        {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required',
            ]);

            // Create a new parameter
            $user = new ResultParameter();
            $user->name = $validatedData['name'];
            $user->description = $validatedData['description'];
            $user->save();

            return redirect('/result-view');
        }

        public function delete(Request $request, $id)
        {
            if(ResultParameter::find($id)->delete())
                return redirect('/result-view');
        }

        public function updateView($id)
        {
            return view("result/updateParameter", ['parameter' => ResultParameter::find($id)]);
        }

        public function update(Request $request, $id)
        {
            $data = $request->except(['_token']);
            ResultParameter::where('id', $id)->update($data);

            return redirect('/result-view');
        }
    }
