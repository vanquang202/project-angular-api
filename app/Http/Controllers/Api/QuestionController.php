<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $questions;
    private $quizs;
    public function __construct(Quiz $quiz, Question $question)
    {
        $this->questions = $question;
        $this->quiz = $quiz;
    }
    public function show($id)
    {
    }
}