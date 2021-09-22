<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetRequest;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;

class ResetController extends Controller
{
    public function reset(ResetRequest $request)
    {
        $email = $request->email;
        $token = $request->token;
        $password = \Hash::make($request->password);

        $emailCheck = \DB::table('password_resets')->where('email', $email)->first();
        $tokenCheck = \DB::table('password_resets')->where('token', $token)->first();

        if (!$emailCheck) {
            return response([
                'message' => 'Email doesn\'t exist'
            ], 400);
        }
        if (!$tokenCheck) {
            return response([
                'message' => 'Invalid Token'
            ], 400);
        }


        // revoke tokens when password reset

        $userId = \DB::table('users')->where('email', $email)->pluck('id')->first();

        $tokenIds = \DB::table('oauth_access_tokens')->where('user_id', $userId)->pluck('id');

        $tokenRepository = app(TokenRepository::class);

        foreach ($tokenIds as $tokenId) {
            $tokenRepository->revokeAccessToken($tokenId);
        }


        \DB::table('users')->where('email', $email)->update(['password' => $password]);
        \DB::table('password_resets')->where('email', $email)->delete();
        return response([
            'message' => 'Password updated successfully'
        ]);
    }
}
