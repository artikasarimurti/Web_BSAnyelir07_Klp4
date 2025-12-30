@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-3xl font-bold">DATA SAMPAH</h2>
        <button class="bg-green-600 text-white px-4 py-2 rounded" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Jenis
        </button>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('jenis.index') }}" class="d-flex mb-3">
        <input type="text" name="search" placeholder="Cari jenis / harga..."
               value="{{ $search ?? '' }}" class="border px-3 py-2 rounded w-1/3">
        <button class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-600" type="submit">Cari</button>
    </form>

    <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Jenis Sampah</th>
                <th>Harga per Kg</th>
                <th width="150px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->nama_jenis }}</td>
                <td>Rp {{ number_format($row->harga_per_kg, 0, ',', '.') }}</td>
                <td>
                    <!-- Edit -->
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEdit{{ $row->id }}">
                        Edit
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('jenis.destroy', $row->id) }}" method="POST"
                        style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('Hapus jenis ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-danger">Data belum ada</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    {{ $data->links() }}

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="{{ route('jenis.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Jenis Sampah</h5>
            </div>

            <div class="modal-body">
                <label>Nama Jenis</label>
                <input type="text" name="nama_jenis" class="form-control mb-2" required>

                <label>Harga per Kg</label>
                <input type="number" name="harga_per_kg" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>

        </form>
    </div>
</div>

<!-- Modal Edit Semua, di luar tabel -->
@foreach($data as $row)
<div class="modal fade" id="modalEdit{{ $row->id }}">
    <div class="modal-dialog">
        <form action="{{ route('jenis.update', $row->id) }}" method="POST" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Jenis Sampah</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Nama Jenis</label>
                <input type="text" name="nama_jenis" class="form-control mb-2"
                       value="{{ $row->nama_jenis }}" required>

                <label>Harga per Kg</label>
                <input type="number" name="harga_per_kg" class="form-control"
                       value="{{ $row->harga_per_kg }}" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection
