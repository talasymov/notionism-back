<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'likes',
        'category_id',
        'tag_id',
        'notion_page_id',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        static::creating(function ($tag) {
            $tag->slug = $tag->slug ?? str($tag->name)->slug();
        });

        static::saving(function ($tag) {
            $tag->slug = $tag->slug ?? str($tag->name)->slug();
        });
    }

    public function templates(): BelongsToMany
    {
        return $this->belongsToMany(Template::class, 'template_tag');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
