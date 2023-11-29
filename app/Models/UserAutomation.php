<?php

namespace App\Models;

use App\Casts\Serialization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAutomation extends Model
{
    use HasFactory;

    protected $table = 'user_automation';

    protected $guarded = [];

    protected $casts = [
        'config' => Serialization::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function automation(): BelongsTo
    {
        return $this->belongsTo(Automation::class);
    }

    public function scopeReadyForSync($q)
    {
        $q->whereRaw('updated_at < now() - interval 15 minute');
    }
}
