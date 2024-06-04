<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices{

    public function create($name, $email, $password){
        User::create([
            "name" => $name,
            "email" => $email,
            "hashed_password" => bcrypt($password)
        ]);
    }

    public function login($email, $password){

        $user = User::where("email", $email)->first();

        if(!empty($user)){
            if(Hash::check($password, $user->password)){
                $token = $user->createToken("myToken")->accessToken;
                return [
                    "status" => true,
                    "message" => "Login Successful",
                    "token" => $token,
                    "data" => []
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "Incorrect password",
                    "data" => []
                ];
            }
        } else {
            return [
                "status" => false,
                "message" => "Invalid credentials",
                "data" => []
            ];
        }
    }

    public function logout($token){
        $token->revoke();
        return [
            "status" => true,
            "message" => "User Logged out successfully"
        ];
    }

}