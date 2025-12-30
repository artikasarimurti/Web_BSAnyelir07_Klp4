@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold">DATA NASABAH</h2>
        <a href="{{ route('nasabah.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">
            + Tambah Nasabah
        </a>
    </div>

    <!-- Ringkasan -->
    <div class="mb-3">
        <strong>Total Saldo:</strong>
        Rp {{ number_format($totalSaldo ?? 0,0,',','.') }}
        &nbsp;&nbsp;
        <strong>Total Setoran:</strong>
        Rp {{ number_format($totalSetoran ?? 0,0,',','.') }}
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('nasabah.index') }}" class="mb-4 flex">
        <input type="text"
               name="search"
               placeholder="Cari nomor induk / nama..."
               value="{{ request('search') }}"
               class="border px-3 py-2 rounded w-1/3">
        <button class="bg-gray-700 text-white px-4 py-2 rounded ml-2 hover:bg-gray-600">
            Cari
        </button>
    </form>

    <!-- Tabel -->
    <table class="table table-bordered w-full text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nomor Induk</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Saldo</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
        @forelse($nasabahs as $n)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $n->nomor_induk }}</strong></td>
                <td>{{ $n->nama }}</td>
                <td>{{ $n->alamat }}</td>
                <td>{{ $n->no_hp }}</td>
                <td>Rp {{ number_format($n->saldo ?? 0,0,',','.') }}</td>
                <td>
                    <a href="{{ route('nasabah.edit',$n->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('nasabah.destroy',$n->id) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus nasabah ini?')"
                                class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Belum ada data nasabah</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $nasabahs->links() }}
    </div>

</div>
@endsection
