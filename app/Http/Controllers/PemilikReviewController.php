<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Kos;
use Illuminate\Support\Facades\Auth;

class PemilikReviewController extends Controller
{
    /**
     * Show all reviews for pemilik's kos
     */
    public function index()
    {
        $pemilikId = Auth::id();

        // Get all reviews for pemilik's kos
        $reviews = Ulasan::with(['kos', 'pencari', 'booking'])
            ->whereHas('kos', function ($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('tgl_ulasan', 'desc')
            ->paginate(15);

        // Calculate stats
        $avgRating = Ulasan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->avg('rating') ?? 0;

        $totalReviews = $reviews->total();

        // Rating distribution
        $ratingDistribution = Ulasan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })
        ->selectRaw('rating, COUNT(*) as count')
        ->groupBy('rating')
        ->orderBy('rating', 'desc')
        ->get()
        ->keyBy('rating');

        return view('pemilik.reviews.index', compact('reviews', 'avgRating', 'totalReviews', 'ratingDistribution'));
    }

    /**
     * Show reviews for specific kos
     */
    public function show($kos_id)
    {
        $pemilikId = Auth::id();

        $kos = Kos::findOrFail($kos_id);

        // Check if this kos belongs to pemilik
        if ($kos->pemilik_id !== $pemilikId) {
            abort(403);
        }

        $reviews = Ulasan::with(['pencari', 'booking'])
            ->where('kos_id', $kos_id)
            ->orderBy('tgl_ulasan', 'desc')
            ->paginate(15);

        $avgRating = Ulasan::where('kos_id', $kos_id)->avg('rating') ?? 0;
        $totalReviews = Ulasan::where('kos_id', $kos_id)->count();

        // Rating distribution
        $ratingDistribution = Ulasan::where('kos_id', $kos_id)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->keyBy('rating');

        return view('pemilik.reviews.show', compact('kos', 'reviews', 'avgRating', 'totalReviews', 'ratingDistribution'));
    }
}
