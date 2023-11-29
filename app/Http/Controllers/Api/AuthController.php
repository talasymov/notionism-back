<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OAuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function me(): JsonResponse
    {
        return response()->json(request()->user());
    }

    public function csrf(): JsonResponse
    {
        return response()->json([
            'password' => Hash::make(request()->get('password'))
        ]);
    }

    public function login(): JsonResponse
    {
        if (request()->has('google_token')) {
            $user = User::query()
                ->whereHas(
                    'oAuthTokens',
                    fn($q) => $q
                        ->where('o_auth_service_id', OAuthService::getGoogleAuth()->id)
                        ->where('token', request()->post('google_token'))
                )
                ->first();

            Auth::login($user);
        } else {
            if (!Auth::attempt(request()->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ]);
            }

            $user = User::where('email', request()->post('email'))->first();
        }

        return response()->json([
            'status' => true,
            'message' => 'Logged',
            'token' => $user->createToken('API')->plainTextToken,
            'user' => $user
        ]);
    }
}
