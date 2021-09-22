<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgetRequest;
use App\Mail\ForgetMail;
use App\Models\User;
use Illuminate\Http\Request;

class ForgetController extends Controller
{
    public function forget(ForgetRequest $request)
    {
        $email = $request->email;

        if (User::where('email', $email)->doesntExist()) {
            return response([
                'message' => 'Email doesn\'t exist'
            ], 400);
        }

        $token = rand(10000, 100000);

        try {
            \DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token
            ]);
            $username = User::where('email', $email)->pluck('username')->first();
            // sending token to the email
            \Mail::to($email)->send(new ForgetMail($token, $username));
            return response([
                'message' => 'Password Resetting pin-code has been send to your email'
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
