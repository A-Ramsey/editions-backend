<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\Commentable;

class Comment extends Model
{
    use HasFactory, Commentable;

    protected $fillable = [
        'content',
    ];

    protected $appends = [
        'commentCount'
    ];

    public static function rules()
    {
        return [
            'content' => 'string|max:1000|min:1'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
