<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2 align="center">LAPORAN TRANSAKSI BULANAN</h2>

<p>
    Periode :
    {{ $tanggal_awal->format('d-m-Y') }}
    s/d
    {{ $tanggal_akhir->format('d-m-Y') }}
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nasabah</th>
            <th>Jenis</th>
            <th>Kg</th>
            <th>Masuk</th>
            <th>Keluar</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
            <td>{{ $row->nasabah->nama ?? '-' }}</td>
            <td>{{ $row->jenis->nama_jenis ?? '-' }}</td>
            <td>{{ $row->kg ?? 0 }}</td>
            <td>Rp {{ number_format($row->uang_masuk ?? 0,0,',','.') }}</td>
            <td>Rp {{ number_format($row->uang_keluar ?? 0,0,',','.') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Tidak ada data</td>
        </tr>
        @endforelse
    </tbody>
</table>

<br>

<strong>
    Total Masuk :
    Rp {{ number_format($total->masuk ?? 0,0,',','.') }}
</strong>

</body>
</html>
