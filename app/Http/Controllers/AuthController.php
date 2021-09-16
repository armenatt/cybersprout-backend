<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'about_me' => $request->about_me,
                'karma' => 1,
                'avatar' => 1,
                'is_banned' => 0,
                'role' => 1,
                'date_of_birth' => $request->date_of_birth,
            ]);
            $token = $user->createToken('cybersprout')->accessToken;
            return response([
                'message' => 'User Registered Successfully',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

    }

    public function login(Request $request)
    {
        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();

                $token = $user->createToken('cybersprout')->accessToken;

                return response([
                    'message' => 'Login Successfully',
                    'token' => $token,
                    'user' => $user
                ], 200);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'Invalid Credentials'
        ], 401);
    }

}
