<?php

namespace App\Http\Controllers;

use App\Models\FotoKamar;
use App\Models\Kamar;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FotoKamarController extends Controller
{
    /**
     * Upload foto untuk kamar
     */
    public function store(Request $request, $kos_id, $kamar_id)
    {
        // Validasi ownership
        $kos = Kos::where('kos_id', $kos_id)
                  ->where('pemilik_id', Auth::id())
                  ->firstOrFail();

        $kamar = Kamar::where('kamar_id', $kamar_id)
                      ->where('kos_id', $kos_id)
                      ->firstOrFail();

        // Validasi file
        $validated = $request->validate([
            'foto' => 'required|image|max:5120', // 5MB
            'deskripsi_foto' => 'nullable|string|max:255',
        ]);

        // Store foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('kamar-photos', 'public');

            FotoKamar::create([
                'kamar_id' => $kamar_id,
                'url_foto' => $path,
                'deskripsi_foto' => $validated['deskripsi_foto'] ?? null,
            ]);

            return back()->with('success', 'Foto berhasil diupload');
        }

        return back()->with('error', 'Gagal mengupload foto');
    }

    /**
     * Delete foto kamar
     */
    public function destroy($foto_id)
    {
        $foto = FotoKamar::with('kamar.kos')->findOrFail($foto_id);

        // Validasi ownership
        if ($foto->kamar->kos->pemilik_id != Auth::id()) {
            abort(403);
        }

        // Delete file dari storage
        if ($foto->url_foto && Storage::disk('public')->exists($foto->url_foto)) {
            Storage::disk('public')->delete($foto->url_foto);
        }

        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus');
    }
}
