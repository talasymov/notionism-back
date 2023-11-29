<?php

namespace App\Models;

use App\Events\ContentChanged;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BlogPost extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $attributes = [
        'name' => 'New template',
        'title' => 'New template',
        'desc' => 'Test desc',
        'slug' => 'hello',
        'preview' => 'no image',
        'page_object' => null,
        'html' => null,
        'notion_page_id' => 'page id'
    ];

    protected $dispatchesEvents = [
        'saved' => ContentChanged::class,
        'deleted' => ContentChanged::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
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
        return $this->belongsToMany(Tag::class, BlogPostTag::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
