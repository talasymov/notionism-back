<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OAuthService extends Model
{
    use HasFactory;

    public static function getGoogleAuth(): Model
    {
        return (new self())
            ->newQuery()
            ->where('codename', 'google-auth')
            ->first();
    }

    public static function getGoogleCalendar(): Model
    {
        return (new self())
            ->newQuery()
            ->where('codename', 'google-calendar')
            ->first();
    }

    public static function getNotion(): Model
    {
        return (new self())
            ->newQuery()
            ->where('codename', 'notion')
            ->first();
    }

    public function tokens(): HasMany
    {
        return $this->hasMany(OAuthToken::class);
    }
}
