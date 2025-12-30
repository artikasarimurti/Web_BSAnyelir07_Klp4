<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSampah;
use App\Models\Nasabah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class TransaksiSampahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = TransaksiSampah::with('nasabah','jenis')
            ->when($search, function($query, $search){
                $query->whereHas('nasabah', fn($q) => $q->where('nama','like',"%{$search}%"))
                    ->orWhereHas('jenis', fn($q) => $q->where('nama_jenis','like',"%{$search}%"));
            })
            ->latest()
            ->paginate(10);

        $totalSaldo = Nasabah::sum('saldo');
        $totalSetoran = TransaksiSampah::sum('uang_masuk');

        return view('transaksi.index', compact('data','search','totalSaldo','totalSetoran'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nasabah_id' => 'required|exists:nasabahs,id',
        'jenis_transaksi' => 'required|in:setoran,penarikan',
        'tanggal' => 'required|date',
        'kg' => 'nullable|numeric|min:0',
        'jenis_id' => 'nullable|exists:jenis_sampah,id',
        'uang_keluar' => 'nullable|numeric|min:0',
        'paraf' => 'nullable|string',
    ]);

    $nasabah = Nasabah::findOrFail($request->nasabah_id);
    $masuk = 0;
    $keluar = 0;
    $harga = 0;

    if ($request->jenis_transaksi == 'setoran') {
        $jenis = JenisSampah::findOrFail($request->jenis_id);
        $harga = $jenis->harga_per_kg;
        $masuk = $request->uang_masuk ?? ($request->kg * $harga);
    } else { // penarikan
        $keluar = $request->uang_keluar ?? 0;
        if ($keluar > $nasabah->saldo) {
            return back()->withErrors(['uang_keluar'=>'Saldo tidak cukup']);
        }
    }

    $saldoBaru = $nasabah->saldo + $masuk - $keluar;

    TransaksiSampah::create([
        'nasabah_id' => $nasabah->id,
        'jenis_transaksi' => $request->jenis_transaksi,
        'jenis_id' => $request->jenis_transaksi == 'setoran' ? $request->jenis_id : null,
        'kg' => $request->jenis_transaksi == 'setoran' ? $request->kg : 0,
        'harga_per_kg' => $harga,
        'uang_masuk' => $masuk,
        'uang_keluar' => $keluar,
        'saldo' => $saldoBaru,
        'tanggal' => $request->tanggal,
        'paraf' => $request->paraf ?? auth()->user()->name,
    ]);

    $nasabah->update(['saldo'=>$saldoBaru]);

    return redirect()->route('transaksi.index')->with('success','Transaksi berhasil disimpan');
}

public function destroy($id)
{
    $transaksi = TransaksiSampah::findOrFail($id);
    $nasabah = $transaksi->nasabah;

    // Kembalikan saldo sesuai jenis transaksi
    if ($transaksi->jenis_transaksi == 'setoran') {
        $nasabah->saldo -= $transaksi->uang_masuk;
    } else {
        $nasabah->saldo += $transaksi->uang_keluar;
    }
    
    $nasabah->save();
    $transaksi->delete();

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
}


}
//php artisan tinker
//DB::table('transaksi_sampah')->delete();
//DB::table('nasabahs')->update(['saldo' => 0]);
