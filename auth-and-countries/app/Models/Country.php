<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'alpha2',
        'alpha3',
        'numeric',
        'license_plate',
        'domain'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
}
