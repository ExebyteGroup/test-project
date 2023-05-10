<?php

namespace Tests\Feature;
use Tests\TestCase;

use App\Http\Controllers\AnswersController;
use App\Models\ResultParameter;
use App\Models\Results;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AnswersControllerTest extends TestCase
{
    public function testStoreAnswer()
    {
        // Create a mock Request object with the 'items' parameter
        $request = new Request([
            'items' => json_encode([
                [
                    "question_id" => 6,
                    "answer_id" => 34
                ],
                [
                    "question_id" => 7,
                    "answer_id" => 39
                ],
                [
                    "question_id" => 8,
                    "answer_id" => 42
                ],
                [
                    "question_id" => 9,
                    "answer_id" => 46
                ],
                [
                    "question_id" => 10,
                    "answer_id" => 51
                ],
                [
                    "question_id" => 11,
                    "answer_id" => 54
                ],
                [
                    "question_id" => 12,
                    "answer_id" => 57
                ],
                [
                    "question_id" => 13,
                    "answer_id" => 60
                ],
                [
                    "question_id" => 14,
                    "answer_id" => 63
                ],
                [
                    "question_id" => 15,
                    "answer_id" => 70
                ]
            ]),
        ]);

        // Call the controll er method
        $controller = new AnswersController();
        $response = $controller->storeAnswer($request);

        // Assert that the response is a view with a ResultParameter model
        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertInstanceOf(ResultParameter::class, $response->result);
    }

    public function testGetAnswers()
    {
        // Call the controller method
        $controller = new AnswersController();
        $response = $controller->getAnswers();

        // Assert that the response is a view with an array of Results models
        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertInstanceOf(Results::class, $response->items[0]);
    }

    public function testGetAnswer()
    {
        $count = Results::all()->last();
        $num = 1;
        if($count)
            $num = $count->key + $num;

        // Create a Result model
        $resultModel = new Results();
        $resultModel->key = $num;
        $resultModel->question_id = 9;
        $resultModel->answer_id = 46;
        $resultModel->save();

        $controller = new AnswersController();
        $response = $controller->getAnswer($num);

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertCount(1, $response->answer);
        $this->assertInstanceOf(Results::class, $response->answer[0]);
    }
}
