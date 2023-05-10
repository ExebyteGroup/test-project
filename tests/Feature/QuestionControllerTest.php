<?php

namespace Tests\Feature;

use App\Http\Controllers\QuestionController;
use App\Models\Answer;
use App\Models\Question;
use App\Models\ResultParameter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class QuestionControllerTest extends TestCase
{
    public function testAddQuestionForm()
    {
        $controller = new QuestionController();
        $result_parameters = ResultParameter::all();

        $view = $controller->addQuestionForm();
        $view_data = $view->getData();

        $this->assertEquals('addQuestion', $view->getName());
        $this->assertArrayHasKey('result_parameters', $view_data);
        $this->assertEquals($result_parameters, $view_data['result_parameters']);
    }

    public function testStore()
    {
        $controller = new QuestionController();
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add([
            'question' => 'What is the capital of France?',
            'answers' => [
                'Paris',
                'London',
                'Berlin',
                'Madrid',
            ],
            'result_answer' => [
                4,
                5,
                6,
                4,
            ],
        ]);

        $controller->store($request);

        $this->assertDatabaseHas('questions', [
            'question' => 'What is the capital of France?',
        ]);

        $this->assertDatabaseHas('answers', [
            'answer' => 'Paris',
        ]);

        $this->assertDatabaseHas('answers', [
            'answer' => 'London',
        ]);

        $this->assertDatabaseHas('answers', [
            'answer' => 'Berlin',
        ]);

        $this->assertDatabaseHas('answers', [
            'answer' => 'Madrid',
        ]);
    }

    public function testStoreWithValidationErrors()
    {
        $controller = new QuestionController();
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add([
            'question' => '', // Empty question, should trigger validation error
            'answers' => [
                'Paris',
                'London',
                'Berlin',
                'Madrid',
            ],
            'result_answer' => [
                4,
                5,
                6,
                4,
            ],
        ]);

        $this->expectException(ValidationException::class);

        $controller->store($request);
    }

    public function testDelete()
    {
        $question = Question::factory()->create();
        $answer1 = Answer::factory()->create(['question_id' => $question->id]);
        $answer2 = Answer::factory()->create(['question_id' => $question->id]);

        $controller = new QuestionController();
        $request = new Request();

        $controller->delete($request, $question->id);

        $this->assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);

        $this->assertDatabaseMissing('answers', [
            'id' => $answer1->id,
        ]);

        $this->assertDatabaseMissing('answers', [
            'id' => $answer2->id,
        ]);
    }

    /**
     * Test updateOut method.
     *
     * @return void
     */
    public function testUpdateOut()
    {
        $question = Question::factory()->create();
        $resultParameter = ResultParameter::factory()->create();

        $response = $this->get(route('questions.update-out', ['id' => $question->id]));

        $response->assertViewIs('update');
        $response->assertViewHas('question', $question);
        $response->assertViewHas('result_parameters', function ($parameters) use ($resultParameter) {
            return $parameters->contains($resultParameter);
        });
    }

    /**
     * Test update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        $question = Question::factory()->create();
        $resultParameter = ResultParameter::factory()->create();
        $answers = [
            'Don’t dare to interrupt them',
            'Interrupt and explain that you are really busy at the moment',
            'Think it’s more important to give them some of your time; work can wait',
        ];
        $resultAnswers = [
            $resultParameter->id,
            $resultParameter->id,
            $resultParameter->id,
        ];

        $response = $this->put(route('questions.update', ['id' => $question->id]), [
            'question' => 'Updated question',
            'answers' => $answers,
            'result_answer' => $resultAnswers,
        ]);

        $this->assertDatabaseMissing('answers', [
            'question_id' => $question->id
        ]);
    }
}
