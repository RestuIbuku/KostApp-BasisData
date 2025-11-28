<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Kos;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KamarController extends Controller
{
    /**
     * Display all rooms for a specific kos
     */
    public function index($kos_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kamars = Kamar::where('kos_id', $kos_id)->with('fasilitas', 'fotoKamar')->paginate(10);

        return view('pemilik.kamar.index', compact('kos', 'kamars'));
    }

    /**
     * Show form untuk membuat kamar baru
     */
    public function create($kos_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $fasilitas = Fasilitas::where('tipe', 'kamar')->get();

        return view('pemilik.kamar.create', compact('kos', 'fasilitas'));
    }

    /**
     * Store kamar baru ke database
     */
    public function store(Request $request, $kos_id)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'ukuran_kamar' => 'nullable|string|max:50',
            'status_ketersediaan' => 'required|in:tersedia,penuh',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        $kamar = Kamar::create([
            'kos_id' => $kos_id,
            'nama_kamar' => $validated['nama_kamar'],
            'harga_per_malam' => $validated['harga_per_malam'],
            'ukuran_kamar' => $validated['ukuran_kamar'],
            'status_ketersediaan' => $validated['status_ketersediaan'],
        ]);

        // Attach fasilitas jika ada
        if (isset($validated['fasilitas'])) {
            $kamar->fasilitas()->attach($validated['fasilitas']);
        }

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil ditambahkan');
    }

    /**
     * Show edit form untuk kamar
     */
    public function edit($kos_id, $kamar_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kamar = Kamar::where('kamar_id', $kamar_id)
                      ->where('kos_id', $kos_id)
                      ->with(['fasilitas', 'fotoKamar'])
                      ->firstOrFail();

        $fasilitas = Fasilitas::where('tipe', 'kamar')->get();
        $selected_fasilitas = $kamar->fasilitas->pluck('fasilitas_id')->toArray();

        return view('pemilik.kamar.edit', compact('kos', 'kamar', 'fasilitas', 'selected_fasilitas'));
    }

    /**
     * Update kamar
     */
    public function update(Request $request, $kos_id, $kamar_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kamar = Kamar::where('kamar_id', $kamar_id)
                      ->where('kos_id', $kos_id)
                      ->firstOrFail();

        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:100',
            'harga_per_malam' => 'required|numeric|min:0',
            'ukuran_kamar' => 'nullable|string|max:50',
            'status_ketersediaan' => 'required|in:tersedia,penuh',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        $kamar->update([
            'nama_kamar' => $validated['nama_kamar'],
            'harga_per_malam' => $validated['harga_per_malam'],
            'ukuran_kamar' => $validated['ukuran_kamar'],
            'status_ketersediaan' => $validated['status_ketersediaan'],
        ]);

        // Sync fasilitas
        if (isset($validated['fasilitas'])) {
            $kamar->fasilitas()->sync($validated['fasilitas']);
        } else {
            $kamar->fasilitas()->detach();
        }

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil diupdate');
    }

    /**
     * Delete kamar
     */
    public function destroy($kos_id, $kamar_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kamar = Kamar::where('kamar_id', $kamar_id)
                      ->where('kos_id', $kos_id)
                      ->firstOrFail();

        $kamar->delete();

        return redirect()->route('pemilik.kamar.index', $kos_id)->with('success', 'Kamar berhasil dihapus');
    }
}
