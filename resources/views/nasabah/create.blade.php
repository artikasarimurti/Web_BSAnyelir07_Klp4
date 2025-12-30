@extends('layouts.app')

@section('content')
<div class="p-6">

    <h2 class="text-xl font-bold mb-4">Tambah Nasabah</h2>

    <form action="{{ route('nasabah.store') }}" method="POST">
        @csrf

        <!-- NOMOR INDUK -->
        <div class="mb-3">
            <label class="font-semibold">Nomor Induk *</label>
            <input type="text"
                   name="nomor_induk"
                   class="border p-2 w-full"
                   placeholder="Contoh: 001"
                   value="{{ old('nomor_induk') }}"
                   required>
            @error('nomor_induk')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- NAMA -->
        <div class="mb-3">
            <label class="font-semibold">Nama *</label>
            <input type="text"
                   name="nama"
                   class="border p-2 w-full"
                   value="{{ old('nama') }}"
                   required>
            @error('nama')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- ALAMAT -->
        <div class="mb-3">
            <label class="font-semibold">Alamat *</label>
            <input type="text"
                   name="alamat"
                   class="border p-2 w-full"
                   value="{{ old('alamat') }}"
                   required>
            @error('alamat')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <!-- NO HP -->
        <div class="mb-3">
            <label class="font-semibold">No HP *</label>
            <input type="text"
                   name="no_hp"
                   class="border p-2 w-full"
                   value="{{ old('no_hp') }}"
                   required>
            @error('no_hp')
                <small class="text-red-600">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>

</div>
@endsection
