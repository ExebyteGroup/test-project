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
                    'question_id' => 1,
                    'answer_id' => 1,
                ],
                [
                    'question_id' => 2,
                    'answer_id' => 2,
                ],
            ]),
        ]);

        // Call the controller method
        $controller = new AnswersController();
        $response = $controller->storeAnswer($request);

        // Assert that the response is a view with a ResultParameter model
        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertInstanceOf(ResultParameter::class, $response->result);
    }

    public function testStoreAnswerWithoutItems()
    {
        // Create a mock Request object without the 'items' parameter
        $request = new Request([]);

        // Call the controller method and expect a validation error
        $controller = new AnswersController();
        $this->expectException(ValidationException::class);
        $controller->storeAnswer($request);
    }

    public function testGetAnswers()
    {
        // Create some Results models
        $results = [
            new Results(['question_id' => 1, 'answer_id' => 1]),
            new Results(['question_id' => 2, 'answer_id' => 2]),
        ];
        Results::insert($results);

        // Call the controller method
        $controller = new AnswersController();
        $response = $controller->getAnswers();

        // Assert that the response is a view with an array of Results models
        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertIsArray($response->items);
        $this->assertCount(2, $response->items);
        $this->assertInstanceOf(Results::class, $response->items[0]);
    }

    public function testGetAnswer()
    {
        // Create a Result model
        $result = new Results(['question_id' => 1, 'answer_id' => 1]);
        $result->key = 1;
        $result->save();

        $controller = new AnswersController();
        $response = $controller->getAnswer(1);

        $this->assertInstanceOf(\Illuminate\Contracts\View\View::class, $response);
        $this->assertIsArray($response->answer);
        $this->assertCount(1, $response->answer);
        $this->assertInstanceOf(Results::class, $response->answer[0]);
    }
}
