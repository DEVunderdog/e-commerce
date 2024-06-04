<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function register(Request $request){
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email",
            "password" => "required"
        ]);

        $this->userServices->create(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        return response()->json([
            "status" => true,
            "message" => "User registered successfully",
            "data" => []
        ]);
    }

    public function login(Request $request){
        $request->validate([
            "email" => "required|string|email",
            "password" => "required"
        ]);

        $response = $this->userServices->login(
            $request->input('email'),
            $request->input('password')
        );

        return response()->json($response);
    }

    public function logout(){
        $token = auth()->user()->token();

        $response = $this->userServices->logout(
            $token
        );

        return response()->json($response);
    }
}
