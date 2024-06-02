<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'check_in_date',
        'check_out_date',
        'status',
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
        ];
    }
}
