<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Image;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function rules(bool $create = false)
    {
        return [
            'name' => ($create ? 'required' : "") . '|string|min:3|max:255',
            'email' => ($create ? 'required' : "") . '|email|' . ($create ? 'unique' : 'exists') . ':users,email',
            'password' => [($create ? 'required' : ""), Password::min(8)
                    ->letters()->mixedCase()->numbers()->symbols()
                ]
        ];
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function postReactions(): MorphToMany
    {
        return $this->morphedByMany(Post::class, 'reactable')->withTimestamps();
    }
}
