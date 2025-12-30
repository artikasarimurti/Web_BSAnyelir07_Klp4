@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Edit Nasabah</h2>

    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nomor Induk</label>
            <input type="text"
                   value="{{ $nasabah->nomor_induk }}"
                   class="border p-2 w-full bg-gray-100"
                   readonly>
        </div>

        <div class="mb-3">
            <label>Nama *</label>
            <input type="text" name="nama" value="{{ $nasabah->nama }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" name="alamat" value="{{ $nasabah->alamat }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" value="{{ $nasabah->no_hp }}" class="border p-2 w-full" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
