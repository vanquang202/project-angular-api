<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Services\QueryViewer\SearchSubject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subject;
    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }

    public function index()
    {
        try {
            $data = $this->subject->a_all(request('limit') ?? 16, ['user'], [SearchSubject::class]);
            if ($data == false) return response()->json(
                [
                    "status" => false,
                    "payload" => 'No data',
                ],
                500
            );
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

    public function show($id)
    {

        try {
            $data = $this->subject->a_show($id, ['quizs' => function ($q) {
                return $q->whereDate('end_time', '>', now())->where('status', 0);
            }, 'user']);
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

    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}