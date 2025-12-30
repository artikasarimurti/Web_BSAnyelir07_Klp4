<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiSampah extends Model
{
    protected $fillable = [
        'nasabah_id',
        'jenis_id',
        'jenis_transaksi',
        'tanggal',
        'kg',
        'uang_masuk',
        'uang_keluar',
        'saldo',
        'paraf',
    ];

    public function nasabah() {
        return $this->belongsTo(Nasabah::class);
    }

    public function jenis() {
        return $this->belongsTo(JenisSampah::class, 'jenis_id');
    }
}
