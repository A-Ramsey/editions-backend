<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Imageable;
use App\Traits\Reactable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Post extends Model
{
    use HasFactory, Commentable, Reactable, Imageable;

    protected $fillable = [
        'content'
    ];

    protected $appends = [
        'reactionCount',
        'commentCount',
        'imageCount',
    ];

    public static function rules()
    {
        return [
            'content' => 'string|max:1000|min:1',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function onDate($date): Collection
    {
        return self::with('user')->with('comments.user')->whereDate('created_at', $date)->get();
    }
}
