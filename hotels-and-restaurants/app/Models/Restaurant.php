<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Business
{
    public function tables(): HasMany
    {
        return $this->hasMany(Table::class);
    }
}
