<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    private $quiz;
    private $user;
    public function __construct(Quiz $quiz, User $user)
    {
        $this->quiz = $quiz;
        $this->user = $user;
    }

    public function show($id)
    {
        try {
            $data = $this->quiz::where('subject_id', $id)->with('subject')->paginate(request('limit') ?? 10);
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Server error"
            ]);
        }
    }

    public function store(Request $request)
    {
        try {

            $data = $this->quiz->a_create(
                array_merge(
                    $request->only(
                        ['name', 'is_shuffle', 'duration_minutes', 'subject_id', 'start_time', 'end_time']
                    ),
                    ['status' => 0]
                )
            );
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể tạo quiz "
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->quiz->a_update(
                $request->only(
                    ['name', 'is_shuffle', 'duration_minutes', 'subject_id', 'start_time', 'end_time']
                ),
                $id
            );
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể cập nhật quiz"
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->quiz->a_destroy($id);
            return response()->json([
                "status" => true,
                "payload" => $id,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể xóa quiz "
            ]);
        }
    }

    public function un_status($id)
    {
        try {
            $quiz = $this->quiz::find($id);
            $quiz->update([
                'status' => 1
            ]);
            return response()->json([
                "status" => true,
                "payload" => $quiz,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể cập nhật  "
            ]);
        }
    }

    public function re_status($id)
    {
        try {
            $quiz = $this->quiz::find($id);
            $quiz->update([
                'status' => 0
            ]);
            return response()->json([
                "status" => true,
                "payload" => $quiz,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể cập nhật"
            ]);
        }
    }
}