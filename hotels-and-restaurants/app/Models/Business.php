<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

abstract class Business extends Model
{
    protected $fillable = [
        'name',
        'website',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($hotel) {
            $hotel->address()->delete();
            $hotel->contact()->delete();
        });
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function contact(): MorphOne
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
