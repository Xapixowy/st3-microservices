<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'id',
        'name',
        'website',
        'description',
        'address',
        'phone',
        'email',
    ];
}
