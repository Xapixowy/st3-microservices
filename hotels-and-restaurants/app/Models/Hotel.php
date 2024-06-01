<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Business
{
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
