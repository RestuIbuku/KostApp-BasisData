<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FasilitasController extends Controller
{
    /**
     * Tampilkan fasilitas untuk kos tertentu
     */
    public function index($kos_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        // Fasilitas umum yang sudah di-attach ke kos
        $fasilitasAktif = $kos->fasilitasUmum()->get();

        // Semua fasilitas umum yang tersedia
        $fasilitasAntrian = Fasilitas::where('tipe', 'umum')->get();

        return view('pemilik.fasilitas.index', compact('kos', 'fasilitasAktif', 'fasilitasAntrian'));
    }

    /**
     * Attach fasilitas ke kos
     */
    public function attach(Request $request, $kos_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $validated = $request->validate([
            'fasilitas_id' => 'required|exists:fasilitas,fasilitas_id',
        ]);

        // Check apakah sudah di-attach
        if (!$kos->fasilitasUmum()->where('fasilitas_id', $validated['fasilitas_id'])->exists()) {
            $kos->fasilitasUmum()->attach($validated['fasilitas_id']);
            return back()->with('success', 'Fasilitas berhasil ditambahkan');
        }

        return back()->with('warning', 'Fasilitas sudah ada');
    }

    /**
     * Detach fasilitas dari kos
     */
    public function detach($kos_id, $fasilitas_id)
    {
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kos->fasilitasUmum()->detach($fasilitas_id);

        return back()->with('success', 'Fasilitas berhasil dihapus');
    }
}
