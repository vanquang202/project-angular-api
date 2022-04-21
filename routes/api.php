<?php

use App\Http\Controllers\Api\Admin\QuestionController;
use App\Http\Controllers\Api\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Api\Admin\SubjectController as AdminSubjectController;
use App\Http\Controllers\Api\FinalController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\StudentQuizController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('subjects', SubjectController::class)->only(['index', 'show']);


Route::prefix('admin')->group(function () {
    Route::resource('subject', AdminSubjectController::class);


    Route::resource('quiz', AdminQuizController::class);
    Route::post('quiz/un-status/{id}', [AdminQuizController::class, 'un_status']);
    Route::post('quiz/re-status/{id}', [AdminQuizController::class, 're_status']);


    Route::resource('question', QuestionController::class);
});

Route::resource('quizs', QuizController::class)->only(['show']);

Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('final-quiz', [FinalController::class, 'finalQuiz']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('history', [StudentQuizController::class, 'index']);
});