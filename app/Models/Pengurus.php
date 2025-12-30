<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'username',
        'password',
        'no_hp',
        'role'
    ];

    //protected $hidden = ['password'];
}
