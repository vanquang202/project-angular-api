<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\StudentQuiz;
use App\Models\StudentQuizDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinalController extends Controller
{
    private $student_quiz;
    private $answer;
    private $user;
    private $student_quiz_detail;

    public function __construct(
        StudentQuiz $student_quiz,
        Answer $answer,
        StudentQuizDetail $student_quiz_detail,
        User $user
    ) {
        $this->student_quiz = $student_quiz;
        $this->answer = $answer;
        $this->user = $user;
        $this->student_quiz_detail = $student_quiz_detail;
    }

    public function finalQuiz(Request $request)
    {
        // try {
        $score = 0;
        DB::transaction(function () use ($request, &$score) {

            $user = $this->user::where('email', $request->email)->first();
            if ($request->status_late) {
                $score = 0;
            } else {
                foreach ($request->result as $point) {
                    $this->answer::where('id', $point['answer'])->where('is_correct', 0)->exists();
                    if ($this->answer::where('id', $point['answer'])->where('is_correct', 0)->exists()) {
                        $score = $score + 1;
                    }
                }
                $score = ($score / count($request->result)) * 10;
            }
            $student_quiz = $this->student_quiz::create(
                [
                    'quiz_id' => $request->quiz_id,
                    'student_id' => $user->id,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'score' => $score
                ]
            );
            foreach ($request->result as $point) {
                $this->student_quiz_detail::create([
                    'student_quiz_id' => $student_quiz->id,
                    'answer_id' => $point['answer'],
                ]);
            }
        });
        return response()->json([
            'status' => true,
            'payload' => $score,
        ]);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         "status" => false,
        //         "payload" => "Server error"
        //     ], 404);
        // }
    }
}