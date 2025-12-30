<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabahs';
    
    protected $fillable = [
        'nomor_induk',
        'nama',
        'alamat',
        'no_hp',
        'saldo'
    ];
}
