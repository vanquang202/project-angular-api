<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $arr = [];
            if ($user = User::where('email', $request->email)->first()) {
                $arr['token'] = $user->createToken('token')->accessToken;
                $arr['user'] = $user;
            } else {
                $user = User::create([
                    "name" => $request->name,
                    "email" => $request->email,
                    "role_id" => 1,
                ]);
                $arr['token'] = $user->createToken('token')->accessToken;
                $arr['user'] = $user;
            }
            return response()->json([
                'status' => true,
                'payload' => $arr,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => "Login failed",
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        try {
            if ($user = User::where('email', $request->user['email'])->first()) {
                $token = $user->tokens->each(function ($token, $key) {
                    $token->delete();
                });
                return response()->json([
                    'status' => true,
                    'payload' => "Logout success !",
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'payload' => "Không tồn tại tài khoản !",
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'payload' => "Logout failed",
            ], 404);
        }
    }
}