<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    private $question;
    private $answer;

    public function __construct(Question $question, Answer $answer)
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $question = $this->question->a_create([
                    "name" => $request->name,
                    "quiz_id" => $request->quiz_id
                ]);
                foreach ($request->answers as $key => $answer) {
                    $this->answer->a_create([
                        "content" => $answer,
                        "question_id" => $question->id,
                        "is_correct" => ($key == ($request->is_correct - 1)) ? 0 : 1,
                    ]);
                }
            });
            return response()->json(
                [
                    "status" => true, //
                    "payload" => "Ok",
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false, //
                    "payload" => $th->getMessage(),
                ],
                404
            );
        }
    }

    public function destroy($id)
    {

        try {
            DB::transaction(function () use ($id) {
                $question = $this->question::find($id);
                $question->answers()->delete();
                $question->delete();
            });
            return response()->json(
                [
                    "status" => true, //
                    "payload" => "ok",
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false, //
                    "payload" => $th->getMessage(),
                ],
                404
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $question = null;
            DB::transaction(function () use ($request, $id, &$question) {
                $question = $this->question::find($id);
                $question->update(["name" => $request->name]);
                foreach ($request->answer_id as $key => $answer) {
                    $this->answer::find($answer)->update(
                        [
                            "content" => $request->value_answers[$key],
                            "is_correct" => ($answer == ($request->is_correct)) ? 0 : 1,
                        ]
                    );
                }
            });
            return response()->json(
                [
                    "status" => true, //
                    "payload" => $question,
                ]
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false, //
                    "payload" => $th->getMessage(),
                ],
                404
            );
        }
    }
}