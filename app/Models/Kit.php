<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kit extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'json',
        'responsive_images' => 'json',
    ];

    protected $guarded = [];

    protected $attributes = [
        'name' => 'New kit',
        'subheader' => 'New kit',
        'title' => 'New kit',
        'desc' => '',
        'slug' => 'hello',
        'preview' => '',
        'responsive_images' => null,
        'price' => 0,
        'prev_price' => 0,
        'link' => '',
        'page_object' => null,
        'html' => null,
        'notion_page_id' => ''
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

    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
    }
}
