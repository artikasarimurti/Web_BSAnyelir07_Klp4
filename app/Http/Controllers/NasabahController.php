<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $nasabahs = Nasabah::when($search, function ($q) use ($search) {
                $q->where('nomor_induk', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy('nomor_induk', 'asc')
            ->paginate(10);

        $totalSaldo   = Nasabah::sum('saldo');
        $totalSetoran = 0;

        return view('nasabah.index', compact(
            'nasabahs',
            'search',
            'totalSaldo',
            'totalSetoran'
        ));
    }

    public function create()
    {
        return view('nasabah.create');
    }

    // ======================
    // 🔹 STORE (TAMBAH DATA)
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            // ⬇️ DIUBAH
            'nomor_induk' => ['required', 'numeric', 'unique:nasabahs,nomor_induk'],
            'nama'        => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'alamat'      => ['required'],
            'no_hp'       => ['required', 'numeric'],
        ], [
            'nomor_induk.numeric' => 'Nomor induk hanya boleh angka',
            'nama.regex'          => 'Nama hanya boleh huruf dan spasi',
            'no_hp.numeric'       => 'No HP hanya boleh angka',
        ]);

        Nasabah::create([
            'nomor_induk' => $request->nomor_induk,
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'no_hp'       => $request->no_hp,
            'saldo'       => 0,
        ]);

        return redirect()->route('nasabah.index')
            ->with('success','Nasabah berhasil ditambahkan');
    }

    public function edit(Nasabah $nasabah)
    {
        return view('nasabah.edit', compact('nasabah'));
    }

    // ======================
    // 🔹 UPDATE (EDIT DATA)
    // ======================
    public function update(Request $request, Nasabah $nasabah)
    {
        $request->validate([
            // ⬇️ DIUBAH
            'nomor_induk' => ['required', 'numeric', 'unique:nasabahs,nomor_induk,' . $nasabah->id],
            'nama'        => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'alamat'      => ['required'],
            'no_hp'       => ['required', 'numeric'],
        ], [
            'nomor_induk.numeric' => 'Nomor induk hanya boleh angka',
            'nama.regex'          => 'Nama hanya boleh huruf dan spasi',
            'no_hp.numeric'       => 'No HP hanya boleh angka',
        ]);

        $nasabah->update([
            'nomor_induk' => $request->nomor_induk,
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'no_hp'       => $request->no_hp,
        ]);

        return redirect()->route('nasabah.index')
            ->with('success','Data nasabah diperbarui');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('nasabah.index')
            ->with('success','Nasabah berhasil dihapus');
    }
}
