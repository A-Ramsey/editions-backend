<?php

namespace App\Models;

use App\Traits\Commentable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory, Commentable;

    protected $fillable = [
        'content'
    ];

    protected $appends = [
        'reactionCount',
        'commentCount',
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

    public function reactable(): MorphToMany
    {
        return $this->morphToMany(User::class, 'reactable')->withTimestamps();
    }

    protected function getReactionCountAttribute(): int
    {
        return $this->reactable->count();
    }
}
