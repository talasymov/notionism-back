<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Widget extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'json'
    ];

    protected $guarded = [];

    protected $attributes = [
        'subscribers_only' => true,
    ];

    public function userWidget(): HasMany
    {
        return $this->hasMany(UserWidget::class);
    }

    public function scopePublished($query)
    {
        $query->where('status', 'publish');
    }

    protected function pageObject(): Attribute
    {
        return Attribute::make(
            get: fn($value) => unserialize($value),
            set: fn($value) => serialize($value),
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, WidgetTag::class);
    }
}
