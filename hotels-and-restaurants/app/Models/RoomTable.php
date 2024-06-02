<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class RoomTable extends Model
{
    protected $fillable = [
        'name',
        'description',
        'capacity',
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
