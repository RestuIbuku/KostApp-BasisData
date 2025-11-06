<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KostController extends Controller
{
    public function index()
    {
        $kosts = Kos::where('pemilik_id', Auth::id())->get();
        return view('kost.index', compact('kosts'));
    }

    public function create()
    {
        return view('kost.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kos' => 'required|string|max:150',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tipe_kos' => 'required|in:putra,putri,campur',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $validatedData['pemilik_id'] = Auth::id();
        Kos::create($validatedData);

        return redirect()->route('kost.index')->with('success', 'Kost berhasil ditambahkan');
    }

    public function edit(Kos $kost)
    {
        return view('kost.edit', compact('kost'));
    }

    public function update(Request $request, Kos $kost)
    {
        $validatedData = $request->validate([
            'nama_kos' => 'required|string|max:150',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'tipe_kos' => 'required|in:putra,putri,campur',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $kost->update($validatedData);
        return redirect()->route('kost.index')->with('success', 'Kost berhasil diupdate');
    }

    public function destroy(Kos $kost)
    {
        $kost->delete();
        return redirect()->route('kost.index')->with('success', 'Kost berhasil dihapus');
    }
}
