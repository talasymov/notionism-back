<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OAuthToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function oAuthService(): BelongsTo
    {
        return $this->belongsTo(OAuthService::class);
    }
}
