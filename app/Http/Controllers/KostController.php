<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{
    public function index()
    {
        $kosts = Kos::where('pemilik_id', Auth::id())->get();
        $total_kosts = $kosts->count();
        $total_kamar_kosong = $kosts->sum('jumlah_kamar_kosong');
        $total_kamar_total = $kosts->sum('jumlah_kamar_total');
        return view('kost.index', compact('kosts', 'total_kosts', 'total_kamar_kosong', 'total_kamar_total'));
    }

    public function create()
    {
        return view('kost.create');
    }

    public function store(Request $request)
    {
        // VALIDASI DIPERKETAT: Foto WAJIB (required)
        $validatedData = $request->validate([
            'nama_kos' => 'required|string|max:150',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Wajib ada, Max 5MB
            'tipe_kos' => 'required|in:putra,putri,campur',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jumlah_kamar_kosong' => 'required|integer|min:0',
            'jumlah_kamar_total' => 'required|integer|min:1',
        ]);

        // LOGIC UPLOAD
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kost-images', 'public');
            $validatedData['foto'] = $path;
        }

        $validatedData['pemilik_id'] = Auth::id();

        // Simpan ke Database
        Kos::create($validatedData);

        return redirect()->route('kost.index')->with('success', 'Kost berhasil ditambahkan');
    }

    // ... method edit, update, destroy biarkan tetap ada ...
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
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'tipe_kos' => 'required|in:putra,putri,campur',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jumlah_kamar_kosong' => 'required|integer|min:0',
            'jumlah_kamar_total' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('foto')) {
            if ($kost->foto && Storage::disk('public')->exists($kost->foto)) {
                Storage::disk('public')->delete($kost->foto);
            }
            $path = $request->file('foto')->store('kost-images', 'public');
            $validatedData['foto'] = $path;
        }

        $kost->update($validatedData);
        return redirect()->route('kost.index')->with('success', 'Kost berhasil diupdate');
    }

    public function destroy(Kos $kost)
    {
        if ($kost->foto && Storage::disk('public')->exists($kost->foto)) {
            Storage::disk('public')->delete($kost->foto);
        }
        $kost->delete();
        return redirect()->route('kost.index')->with('success', 'Kost berhasil dihapus');
    }
}