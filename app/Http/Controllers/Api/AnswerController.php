<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function index()
    {
        try {
            $data = $this->answer->a_all(request('limit') ?? 20);
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Server not found"
                ],
                404
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $this->answer::create($request->all());
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Server not found"
                ],
                404
            );
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $find = $this->answer::find($id);
            $find = $find->update($request->all());
            return response()->json([
                "status" => true,
                "payload" => $find
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Server not found"
                ],
                404
            );
        }
    }
    public function destroy($id)
    {
        try {
            $this->answer::destroy($id);
            return response()->json([
                "status" => true,
                "payload" => "Success"
            ]);
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "status" => false,
                    "payload" => "Server not found"
                ],
                404
            );
        }
    }
}