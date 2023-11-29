<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OAuthService;
use App\Models\OAuthToken;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class LoginSocialiteController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function redirectGoogleCalendar()
    {
        $scopes = [
            'https://www.googleapis.com/auth/calendar'
        ];

        return Socialite::driver('google')
            ->scopes($scopes)
            ->redirectUrl(config('services.google.redirect_calendar'))
            ->with(['access_type' => 'offline', 'prompt' => 'consent select_account'])
            ->redirect();
    }

    public function redirectNotion()
    {
        return Socialite::driver('notion')
            ->with([
                'state' => request()->get('token')
            ])
            ->redirect();
    }

    public function callbackGoogle()
    {
        $socialUser = Socialite::driver('google')->stateless()->user();

        $service = OAuthService::getGoogleAuth();

        $user = User::query()->updateOrCreate([
            'email' => $socialUser->email,
        ], [
            'name' => $socialUser->name,
            'avatar' => $socialUser->avatar,
        ]);

        OAuthToken::query()->updateOrCreate([
            'o_auth_service_id' => $service->id,
            'client_id' => $socialUser->id,
            'user_id' => $user->id,
        ], [
            'token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
        ]);

        return redirect(config('app.frontend_url') . '/login?google_token=' . $socialUser->token);
    }

    public function callbackGoogleCalendar()
    {
        $scopes = [
            'https://www.googleapis.com/auth/calendar'
        ];

        $socialUser = Socialite::driver('google')
            ->scopes($scopes)
            ->redirectUrl(config('services.google.redirect_calendar'))
            ->stateless()
            ->user();

        $service = OAuthService::getGoogleCalendar();

        $user = User::query()->where('email', $socialUser->email)->first();

        OAuthToken::query()->updateOrCreate([
            'o_auth_service_id' => $service->id,
            'client_id' => $socialUser->id,
            'user_id' => $user->id,
        ], [
            'token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
        ]);

        return redirect(
            config('app.frontend_url') . '/dashboard/integrations?status=connected&service=' . $service->codename
        );
    }

    public function callbackNotion()
    {
        $socialUser = Socialite::driver('notion')->stateless()->user();

        $service = OAuthService::getNotion();

        $user = PersonalAccessToken::findToken(request()->get('state'))->tokenable;

        $status = 'connected';

        OAuthToken::query()->updateOrCreate([
            'o_auth_service_id' => $service->id,
            'client_id' => $socialUser->id,
            'user_id' => $user->id,
        ], [
            'token' => $socialUser->token,
            'refresh_token' => $socialUser->refreshToken,
        ]);

        return redirect(
            config('app.frontend_url') . "/dashboard/integrations?status={$status}&service={$service->codename}"
        );
    }
}
