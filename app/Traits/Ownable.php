<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Ownable {
    public function ownedByAuthUser() {
        return $this->user->id == Auth::user()->id;
    }
}
