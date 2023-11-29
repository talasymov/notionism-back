<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class UserWidget extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'user_widget';

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_id',
        'widget_id',
        'uuid',
        'name',
        'config',
        'viewed_at',
    ];

    protected $casts = [
        'config' => 'json'
    ];
    
    protected $dates = [
        'viewed_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute('uuid', Uuid::uuid4());
        });
    }

    public function widget(): BelongsTo
    {
        return $this->belongsTo(Widget::class);
    }
}
