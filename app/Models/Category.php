<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const CAT_FIELD = 1;
    public const CAT_CASE = 2;
    public const CAT_BOOK = 3;
    public const CAT_LOOK = 4;

    protected $fillable = [
        'name',
        'slug',
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
}
