<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Reactable {

    public function reactable(): MorphToMany
    {
        return $this->morphToMany(User::class, 'reactable')->withTimestamps();
    }

    protected function getReactionCountAttribute(): int
    {
        return $this->reactable->count();
    }
}
