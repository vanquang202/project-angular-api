<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    private $subject;
    private $user;

    public function __construct(Subject $subject, User $user)
    {
        $this->subject = $subject;
        $this->user = $user;
    }

    public function index()
    {
        try {
            $data = $this->subject::orderBy('id', 'desc')->paginate(request('limit') ?? 8);
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
            if (!(($user = $this->user::where('email', $request->email)->first())->role_id == 2)) {
                return response()->json([
                    "status" => false,
                    "payload" => "Tài khoản không tồn tại "
                ]);
            }

            $data = $this->subject->a_create(array_merge($request->only(['name']), ['author_id' => $user->id]));
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể tạo môn học "
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $this->subject->a_update($request->except(['author_id']), $id);
            return response()->json([
                "status" => true,
                "payload" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể cập nhật môn học "
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->subject->a_destroy($id);
            return response()->json([
                "status" => true,
                "payload" => $id,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "payload" => "Không thể xóa môn học "
            ]);
        }
    }
}