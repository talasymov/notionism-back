<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateHistory extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'json'
    ];

    protected $guarded = [];

    protected $attributes = [
        'name' => 'New template',
        'title' => 'New template',
        'desc' => '',
        'ver' => null,
        'dbs' => 0,
        'props' => 0,
        'pages' => 0,
        'slug' => 'new-template',
        'preview' => '',
        'price' => 0,
        'link' => '',
        'page_object' => null,
        'notion_page_id' => ''
    ];
}
