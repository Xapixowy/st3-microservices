<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    protected $fillable = [
        'street',
        'building_number',
        'city',
        'zip_code',
        'country_numeric',
        'business_id',
    ];

    protected $hidden = [
        'addressable_id',
        'addressable_type',
        'created_at',
        'updated_at',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
