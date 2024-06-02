<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = [
        'name',
        'alpha2',
        'alpha3',
        'numeric',
        'license_plate',
        'domain',
        'isComplete'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'isComplete' => 'boolean'
        ];
    }
}
