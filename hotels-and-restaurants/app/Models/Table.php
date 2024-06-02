<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Table extends RoomTable
{
    public function __construct()
    {
        parent::__construct();

        $this->fillable = array_merge($this->fillable, [
            'restaurant_id',
        ]);

        $this->hidden = array_merge($this->hidden, [
            'restaurant_id',
        ]);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
