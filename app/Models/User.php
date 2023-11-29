<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
        'google_token',
        'google_refresh_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return in_array($this->id, [1, 2]);
    }

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }

    public function userWidgets(): HasMany
    {
        return $this->hasMany(UserWidget::class);
    }

    public function oAuthTokens(): HasMany
    {
        return $this->hasMany(OAuthToken::class);
    }

    public function oAuthGoogleAuthToken(): HasOne
    {
        return $this->hasOne(OAuthToken::class)
            ->whereHas(
                'oAuthService',
                fn($q) => $q->where('codename', \App\Enums\OAuthService::GoogleAuth->value)
            );
    }

    public function oAuthGoogleCalendarToken(): HasOne
    {
        return $this->hasOne(OAuthToken::class)
            ->whereHas(
                'oAuthService',
                fn($q) => $q->where('codename', \App\Enums\OAuthService::GoogleCalendar->value)
            );
    }

    public function oAuthNotionToken(): HasOne
    {
        return $this->hasOne(OAuthToken::class)
            ->whereHas(
                'oAuthService',
                fn($q) => $q->where('codename', \App\Enums\OAuthService::Notion->value)
            );
    }
}
