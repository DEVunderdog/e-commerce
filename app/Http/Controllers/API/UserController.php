<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email",
            "password" => "required"
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "hashed_password" => bcrypt($request->password)
        ]);

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

        $user = User::where("email", $request->email)->first();

        if(!empty($user)){
            if(Hash::check($request->password, $user->hashed_password)){
                $token = $user->createToken("mytoken")->accessToken;
                return response()->json([
                    "status" => true,
                    "message" => "Login Successful",
                    "token" => $token,
                    "data" => [],
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "message" => "incorrect password",
                    "data" => []
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid credentials",
                "data" => []
            ]);
        }
    }

    public function logout(){
        $token = auth()->user()->token();

        $token -> revoke();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }
}
