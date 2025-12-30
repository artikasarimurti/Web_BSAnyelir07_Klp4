@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-3xl font-bold">SETORAN SAMPAH</h2>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500" data-bs-toggle="modal" data-bs-target="#modalTambah">+ Tambah Transaksi</button>
    </div>

    <!-- Ringkasan -->
    <div class="mb-3">
        <span class="me-4">
            <strong>Total Saldo:</strong> 
            Rp {{ number_format($totalSaldo, 0, ',', '.') }}
        </span>
        <span>
            <strong>Total Setoran:</strong> 
            Rp {{ number_format($totalSetoran, 0, ',', '.') }}
        </span>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex mb-3">
        <input type="text" name="search" placeholder="Cari nasabah / jenis..."
               value="{{ $search ?? '' }}" class="border px-3 py-2 rounded w-1/3" style="width: 300px;">
        <button class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-600" type="submit">Cari</button>
    </form>

    <!-- Tabel Transaksi -->
    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nasabah</th>
                <th>Jenis</th>
                <th>Kg</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Saldo</th>
                <th>Paraf</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('Y-m-d') }}</td>
                <td>{{ $row->nasabah->nama }}</td>
                <td>{{ $row->jenis ? $row->jenis->nama_jenis : '-' }}</td>
                <td>{{ $row->kg }}</td>
                <td>Rp {{ number_format($row->uang_masuk ?? 0,0,',','.') }}</td>
                <td>Rp {{ number_format($row->uang_keluar ?? 0,0,',','.') }}</td>
                <td>Rp {{ number_format($row->saldo,0,',','.') }}</td>
                <td>{{ $row->paraf }}</td>
                <td>
                    <form action="{{ route('transaksi.destroy', $row->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Hapus transaksi ini?')" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="10">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $data->links() }}

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('transaksi.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Transaksi</h5>
            </div>
            <div class="modal-body">
                <label>Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="tipeTransaksi" class="form-control" required>
                        <option value="setoran">Setor Sampah</option>
                        <option value="penarikan">Tarik Tabungan</option>
                    </select>

                    <div class="modal-body">
                        <label>Nasabah</label>
                        <select name="nasabah_id" class="form-control" required>
                            @foreach(App\Models\Nasabah::all() as $nasabah)
                                <option value="{{ $nasabah->id }}">{{ $nasabah->nama }}</option>
                            @endforeach
                        </select>

                        <div id="setoranFields">
                            <label>Jenis Sampah</label>
                            <select name="jenis_id" class="form-control" id="jenisSelect">
                                @foreach(App\Models\JenisSampah::all() as $jenis)
                                    <option value="{{ $jenis->id }}" data-harga="{{ $jenis->harga_per_kg }}">{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </select>

                            <label>Kg</label>
                            <input type="number" step="0.01" name="kg" class="form-control" id="kgInput">

                            <label>Masuk (Rp)</label>
                            <input type="number" class="form-control" id="masukInput" readonly>
                        </div>

                        <div id="penarikanField" style="display:none;">
                            <label>Keluar (Rp)</label>
                            <input type="number" name="uang_keluar" class="form-control">
                        </div>

                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>

                        <label>Paraf</label>
                        <input type="text" name="paraf" class="form-control">
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipe = document.getElementById('tipeTransaksi');
    const setoranFields = document.getElementById('setoranFields');
    const penarikanField = document.getElementById('penarikanField');
    const jenisSelect = document.getElementById('jenisSelect');
    const kgInput = document.getElementById('kgInput');
    const masukInput = document.getElementById('masukInput');

    function updateMasuk() {
        const harga = parseFloat(jenisSelect.options[jenisSelect.selectedIndex]?.dataset.harga || 0);
        const kg = parseFloat(kgInput.value || 0);
        const total = harga * kg;
        masukInput.value = total;
        document.getElementById('hiddenMasukInput').value = total;
    }


    tipe.addEventListener('change', function() {
        if(tipe.value == 'setoran') {
            setoranFields.style.display = 'block';
            penarikanField.style.display = 'none';
            kgInput.value = '';
            masukInput.value = '';
        } else {
            setoranFields.style.display = 'none';
            penarikanField.style.display = 'block';
        }
    });

    jenisSelect.addEventListener('change', updateMasuk);
    kgInput.addEventListener('input', updateMasuk);
});

</script>
@endsection
