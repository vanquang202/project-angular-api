<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        try {
            $data = $this->user::all();
            return response()->json(
                [
                    "status" => true,
                    "payload" => null,
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