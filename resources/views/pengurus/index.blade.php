@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold">DATA PENGURUS</h2>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Pengurus
        </button>
    </div>

    <form method="GET" action="{{ route('pengurus.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama/email..."
            class="border px-3 py-2 rounded w-1/3">
        <button type="submit"
            class="bg-gray-700 text-white px-3 py-2 rounded hover:bg-gray-600">
            Cari
        </button>
    </form>

   <div class="overflow-x-auto bg-white p-4 rounded shadow">
    <table class="min-w-full border rounded-lg text-sm">
        <thead class="bg-black text-white uppercase tracking-wide text-sm">
            <tr>
                <th class="py-2 border">No</th>
                <th class="py-2 border">Nama</th>
                <th class="py-2 border">Email</th>
                <th class="py-2 border">No HP</th>
                <th class="py-2 border">Role</th>
                <th class="py-2 border" width="130">Aksi</th>
            </tr>
        </thead>

            <tbody>
                @forelse($data as $user)
                <tr class="text-center">
                    <td class="py-2 border">{{ $loop->iteration }}</td>
                    <td class="py-2 border">{{ $user->name }}</td>
                    <td class="py-2 border">{{ $user->email }}</td>
                    <td class="py-2 border">{{ $user->no_hp ?? '-' }}</td>
                    <td class="py-2 border">{{ ucfirst($user->role) }}</td>
                    <td class="py-2 border flex justify-center gap-2">

                        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-400"
                            data-bs-toggle="modal" data-bs-target="#edit{{ $user->id }}">
                            Edit
                        </button>

                        <form action="{{ route('pengurus.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin ingin menghapus?')"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-400">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-3 border text-center text-gray-500">
                        Tidak ada data pengurus
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pengurus.store') }}" method="POST"
              class="modal-content border-0 shadow-lg rounded-3">
            @csrf
            <div class="modal-header bg-green-600">
                <h5 class="modal-title text-white">Tambah Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control mb-3" required>

                <label>Email</label>
                <input type="email" name="email" class="form-control mb-3" required>

                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required>

                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control mb-3" required>

                <label>Role</label>
                <select name="role" class="form-select mb-3">
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
@foreach($data as $user)
<div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pengurus.update', $user->id) }}" method="POST"
              class="modal-content border-0 shadow-lg rounded-3">
            @csrf
            @method('PUT')

            <div class="modal-header bg-blue-600">
                <h5 class="modal-title text-white">Edit Pengurus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <label class="font-semibold">Nama</label>
                <input type="text" name="nama" class="form-control mb-3" value="{{ $user->name }}" required>

                <label class="font-semibold">Email</label>
                <input type="email" name="email" class="form-control mb-3" value="{{ $user->email }}" required>

                <label class="font-semibold">Password (opsional)</label>
                <input type="password" name="password" class="form-control mb-3">

                <label class="font-semibold">No HP</label>
                <input type="text" name="no_hp" class="form-control mb-3" value="{{ $user->no_hp }}">

                <label class="font-semibold">Role</label>
                <select name="role" class="form-select mb-3">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endforeach


@endsection
