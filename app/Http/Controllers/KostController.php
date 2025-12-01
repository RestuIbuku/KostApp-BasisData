<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Kamar;
use App\Models\Fasilitas;
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
        return view('pemilik.kost.index', compact('kosts', 'total_kosts', 'total_kamar_kosong', 'total_kamar_total'));
    }

    public function create()
    {
        // Ambil fasilitas berdasarkan tipe
        $fasilitas_umum = Fasilitas::where('tipe', 'umum')->get();
        $fasilitas_kamar = Fasilitas::where('tipe', 'kamar')->get();

        return view('pemilik.kost.create', compact('fasilitas_umum', 'fasilitas_kamar'));
    }

    public function store(Request $request)
    {
        // VALIDASI DATA KOST
        $validatedData = $request->validate([
            'nama_kos' => 'required|string|max:150',
            'alamat' => 'required|string',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'tipe_kos' => 'required|in:putra,putri,campur',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jumlah_kamar_kosong' => 'required|integer|min:0',
            'jumlah_kamar_total' => 'required|integer|min:1',
            'fasilitas_umum' => 'nullable|array',
            'fasilitas_umum.*' => 'exists:fasilitas,fasilitas_id',
            'kamar' => 'required|array|min:1',
            'kamar.*.nama_kamar' => 'required|string|max:100',
            'kamar.*.harga_per_malam' => 'required|numeric|min:0',
            'kamar.*.ukuran_kamar' => 'nullable|string|max:50',
            'kamar.*.status_ketersediaan' => 'required|in:tersedia,penuh',
            'kamar.*.fasilitas' => 'nullable|array',
            'kamar.*.fasilitas.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kost-images', 'public');
            $validatedData['foto'] = $path;
        }

        $validatedData['pemilik_id'] = Auth::id();

        // SIMPAN KOS
        $kos = Kos::create($validatedData);

        // SIMPAN FASILITAS UMUM
        if (isset($validatedData['fasilitas_umum']) && !empty($validatedData['fasilitas_umum'])) {
            $kos->fasilitasUmum()->attach($validatedData['fasilitas_umum']);
        }

        // SIMPAN KAMAR DAN FASILITAS KAMAR
        if (isset($validatedData['kamar'])) {
            foreach ($validatedData['kamar'] as $kamarData) {
                $kamarDataToSave = [
                    'kos_id' => $kos->kos_id,
                    'nama_kamar' => $kamarData['nama_kamar'],
                    'harga_per_malam' => $kamarData['harga_per_malam'],
                    'ukuran_kamar' => $kamarData['ukuran_kamar'] ?? null,
                    'status_ketersediaan' => $kamarData['status_ketersediaan'],
                ];

                $kamar = Kamar::create($kamarDataToSave);

                // Attach fasilitas kamar jika ada
                if (isset($kamarData['fasilitas']) && !empty($kamarData['fasilitas'])) {
                    $kamar->fasilitas()->attach($kamarData['fasilitas']);
                }
            }
        }

        return redirect()->route('pemilik.kos.index')->with('success', 'Kost beserta kamar dan fasilitas berhasil ditambahkan');
    }

    public function edit($kos_id)
    {
        $kost = Kos::where('kos_id', $kos_id)
                   ->where('pemilik_id', Auth::id())
                   ->firstOrFail();

        // Check authorization
        if ($kost->pemilik_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses kos ini');
        }

        $fasilitas_umum = Fasilitas::where('tipe', 'umum')->get();
        $selected_fasilitas = $kost->fasilitasUmum->pluck('fasilitas_id')->toArray();

        return view('pemilik.kost.edit', compact('kost', 'fasilitas_umum', 'selected_fasilitas'));
    }

    public function update(Request $request, $kos_id)
    {
        $kost = Kos::where('kos_id', $kos_id)
                   ->where('pemilik_id', Auth::id())
                   ->firstOrFail();

        // Check authorization
        if ($kost->pemilik_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses kos ini');
        }

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
            'fasilitas_umum' => 'nullable|array',
            'fasilitas_umum.*' => 'exists:fasilitas,fasilitas_id',
        ]);

        if ($request->hasFile('foto')) {
            if ($kost->foto && Storage::disk('public')->exists($kost->foto)) {
                Storage::disk('public')->delete($kost->foto);
            }
            $path = $request->file('foto')->store('kost-images', 'public');
            $validatedData['foto'] = $path;
        }

        $kost->update($validatedData);

        // Update fasilitas umum
        if (isset($validatedData['fasilitas_umum'])) {
            $kost->fasilitasUmum()->sync($validatedData['fasilitas_umum']);
        } else {
            $kost->fasilitasUmum()->sync([]);
        }

        return redirect()->route('pemilik.kos.index')->with('success', 'Kost berhasil diupdate');
    }

    public function destroy($kos_id)
    {
        $kost = Kos::where('kos_id', $kos_id)
                   ->where('pemilik_id', Auth::id())
                   ->firstOrFail();

        if ($kost->foto && Storage::disk('public')->exists($kost->foto)) {
            Storage::disk('public')->delete($kost->foto);
        }
        $kost->delete();
        return redirect()->route('pemilik.kos.index')->with('success', 'Kost berhasil dihapus');
    }
}
