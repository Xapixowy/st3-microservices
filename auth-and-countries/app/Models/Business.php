<?php

namespace App\Models;

abstract class Business extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'zip_code',
        'country_numeric',
        'phone',
        'email',
        'website',
        'description',
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
