<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends RoomTable
{
    public function __construct()
    {
        parent::__construct();

        $this->fillable = array_merge($this->fillable, [
            'price',
            'hotel_id',
        ]);

        $this->hidden = array_merge($this->hidden, [
            'hotel_id',
        ]);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
