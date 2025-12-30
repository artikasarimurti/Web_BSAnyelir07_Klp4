<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Pengurus;
use App\Models\JenisSampah;
use App\Models\User;
use App\Models\TransaksiSampah;

class DashboardController extends Controller
{
    public function index()
    {
        $totalNasabah = Nasabah::count();
        $totalPengurus = User::whereIn('role', ['admin', 'petugas'])->count();
        // Total kg bulan ini
        $setoranBulanIni = TransaksiSampah::whereMonth('created_at', now()->month)
                    ->sum('kg');
        // Total saldo dari seluruh transaksi masuk
        $saldoTerkumpul = TransaksiSampah::sum('uang_masuk') - TransaksiSampah::sum('uang_keluar');
        // Total jenis sampah
        $jenisSampah = JenisSampah::count();
        // Total setoran hari ini
        $setoranHariIni = TransaksiSampah::whereDate('created_at', now())->count();

        return view('dashboard', compact(
            'totalNasabah',
            'totalPengurus',
            'setoranBulanIni',
            'saldoTerkumpul',
            'jenisSampah',
            'setoranHariIni'
        ));
    }
}
