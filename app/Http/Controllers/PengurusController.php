<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PengurusController extends Controller
{
    // Tampil dengan pencarian
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'petugas']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $data = $query->orderBy('name')->get();
        return view('pengurus.index', compact('data'));
    }

    //tamba
    public function store(Request $request)
    {
        $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:5',
        'role' => 'required',
        'no_hp' => 'nullable',
    ]);

    User::create([
        'name' => $request->nama,
        'email' => $request->email,   // ini sekarang sesuai input
        'password' => bcrypt($request->password),
        'role' => $request->role,
        'no_hp' => $request->no_hp,
    ]);

        return back()->with('success', 'Pengurus berhasil ditambahkan!');
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required',
            'no_hp' => 'nullable',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();


        return back()->with('success', 'Pengurus berhasil diupdate!');
    }



    // Hapus pengurus
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->back()->with('success', 'Pengurus berhasil dihapus!');
    }
}
