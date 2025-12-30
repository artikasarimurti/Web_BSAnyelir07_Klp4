@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Judul -->
    <div class="text-2xl font-bold mb-6">BANK SAMPAH DIGITAL</div>

    <!-- Card Info: Baris 1 -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 shadow rounded-lg">
            <div class="text-gray-700 font-medium">Total Pengurus</div>
            <div class="text-2xl font-bold mt-2">{{ $totalPengurus }}</div>
        </div>

        <div class="bg-white p-5 shadow rounded-lg">
            <div class="text-gray-700 font-medium">Total Nasabah</div>
            <div class="text-2xl font-bold mt-2">{{ $totalNasabah }}</div>
        </div>

        <div class="bg-white p-5 shadow rounded-lg">
            <div class="text-gray-700 font-medium">Total Setoran Bulan Ini</div>
            <div class="text-2xl font-bold mt-2">{{ $setoranBulanIni }} kg</div>
        </div>
    </div>

    <!-- Card Info: Baris 2 -->
    <div class="grid grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-5 shadow rounded-lg">
        <div class="text-gray-700 font-medium">Saldo Terkumpul</div>
        <div class="text-2xl font-bold mt-2">
            Rp {{ number_format($saldoTerkumpul, 0, ',', '.') }}
        </div>
    </div>

        <div class="bg-white p-5 shadow rounded-lg">
            <div class="text-gray-700 font-medium">Jenis Sampah Terdaftar</div>
            <div class="text-2xl font-bold mt-2">{{ $jenisSampah }}</div>
        </div>

        <div class="bg-white p-5 shadow rounded-lg">
            <div class="text-gray-700 font-medium">Setoran Hari Ini</div>
            <div class="text-2xl font-bold mt-2">{{ $setoranHariIni }}</div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-4 border-b pb-2">Aktivitas Terbaru</h2>
        <div class="h-48 overflow-y-auto">
            @foreach(App\Models\TransaksiSampah::latest()->take(5)->get() as $transaksi)
                <div class="border-b py-2">
                    <span class="font-semibold">{{ $transaksi->nasabah->nama ?? 'Nama Nasabah' }}</span> 
                    setor {{ $transaksi->kg }} kg
                    <span class="text-gray-500 text-sm block">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i') }}</span>
                </div>
            @endforeach

        </div>
    </div>

</div>
@endsection
