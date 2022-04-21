<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StudentQuiz;
use App\Models\User;
use Illuminate\Http\Request;

class StudentQuizController extends Controller
{
    private $student_quiz;
    private $user;
    public function __construct(StudentQuiz $student_quiz, User $user)
    {
        $this->student_quiz = $student_quiz;
        $this->user = $user;
    }

    public function index(Request $request)
    {
        // try {
        if ($user = $this->user::where('email', $request->user['email'] ?? "")->first()) {
            $data = $this->student_quiz::where('student_id', $user->id)
                ->with(['student_quiz_detail', 'quizs'])
                ->orderBy('id', 'desc')
                ->paginate(request('limit') ?? 10);
            return response()->json(
                [
                    "status" => true,
                    "payload" => $data
                ],
            );
        } else {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Không tim thấy tài khoản "
                ],
            );
        }
        // } catch (\Throwable $th) {
        //     return response()->json(
        //         [
        //             "status" => false,
        //             "payload" => "Serve not found "
        //         ],
        //         404
        //     );
        // }
    }
}