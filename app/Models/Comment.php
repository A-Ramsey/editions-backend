<?php

namespace App\Models;

use App\Traits\Reactable;
use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory, Commentable, Reactable;

    protected $fillable = [
        'content',
    ];

    protected $appends = [
        'commentCount',
        'reactionCount'
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
