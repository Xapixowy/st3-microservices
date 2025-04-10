<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];
}
