<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $quiz;
    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }
    public function  show($id)
    {
        $data = $this->quiz->a_show($id, ['questions']);
        try {
            $data = $this->quiz->a_show($id, ['questions']);
            return response()->json(
                [
                    "status" => true,
                    "payload" => $data,
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => 'Server not found ',
                ],
                404
            );
        }
    }
}