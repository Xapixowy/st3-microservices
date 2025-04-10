<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'check_in_date',
        'check_out_date',
        'hotel_id',
        'room_id',
        'restaurant_id',
        'table_id',
        'is_paid'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'check_in_date' => 'datetime',
            'check_out_date' => 'datetime',
            'is_paid' => 'boolean',
        ];
    }
}
