<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $data = JenisSampah::when($search, function ($query, $search) {
            return $query->where('nama_jenis', 'like', "%{$search}%")
                        ->orWhere('harga_per_kg', 'like', "%{$search}%");
        })->orderBy('id', 'DESC')->paginate(5);

        return view('jenis.index', compact('data', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'harga_per_kg' => 'required|numeric',
        ]);

        JenisSampah::create($request->all());
        return redirect()->route('jenis.index')->with('success', 'Jenis sampah berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'harga_per_kg' => 'required|numeric',
        ]);

        $jenis = JenisSampah::findOrFail($id);
        $jenis->update($request->all());

        return redirect()->route('jenis.index')->with('success', 'Jenis sampah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        JenisSampah::destroy($id);
        return redirect()->route('jenis.index')->with('success', 'Jenis sampah berhasil dihapus!');
    }
}
