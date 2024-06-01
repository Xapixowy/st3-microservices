<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Model
{
    protected $fillable = [
        'phone',
        'email',
    ];

    protected $hidden = [
        'contactable_id',
        'contactable_type',
        'created_at',
        'updated_at',
    ];

    public function contactable(): MorphTo
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
