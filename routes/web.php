<?php

    use App\Http\Controllers\AnswersController;
    use App\Http\Controllers\QuestionController;
    use App\Http\Controllers\QuestionStepsController;
    use App\Http\Controllers\ResultParameterController;
    use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', QuestionStepsController::class.'@getSteps');
Route::get('questions', QuestionStepsController::class.'@getQuestions');

Route::get('question/add', QuestionController::class.'@addQuestionForm');
Route::post('store', QuestionController::class.'@store');
Route::delete('question/delete/{id}', QuestionController::class.'@delete');

Route::get('question/updateOut/{id}',QuestionController::class.'@updateOut')->name('questions.update-out');
Route::post('question/update/{id}', QuestionController::class.'@update')->name('questions.update');

Route::post('answers/store', AnswersController::class.'@storeAnswer');
Route::get('answers', AnswersController::class.'@getAnswers');
Route::get('answers/{id}', AnswersController::class.'@getAnswer');

Route::get('result-view', ResultParameterController::class.'@resultView');
Route::get('result-parameter/create', ResultParameterController::class.'@createResultParameter');
Route::get('result-parameter/update/{id}', ResultParameterController::class.'@updateView');
Route::post('result-parameter/store', ResultParameterController::class.'@store');
Route::post('result-parameter/update/{id}', ResultParameterController::class.'@update');
Route::delete('result-parameter/delete/{id}', ResultParameterController::class.'@delete');
