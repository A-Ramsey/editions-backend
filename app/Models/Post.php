<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    protected $appends = [
        'reactionsCount',
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
        return $this->morphToMany(User::class, 'reactable');
    }

    protected function getReactionsCountAttribute(): int
    {
        return $this->reactable->count();
    }
}
