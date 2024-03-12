<?php

namespace App\Models;

use App\Traits\Reactable;
use App\Traits\Commentable;
use App\Traits\Ownable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Image extends Model
{
    use HasFactory, Commentable, Reactable, Ownable;

    protected $fillable = [
        'filename',
    ];

    protected $appends = [
        'commentCount',
        'reactionCount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function store(UploadedFile $file)
    {
        $filename = 'EDITIONS_' . Date::now()->timestamp;
        Storage::put($filename, $file);

        $image = User::find(Auth::user()->id)->images()->create(['filename' => $filename]);
        return $image;
    }
}
