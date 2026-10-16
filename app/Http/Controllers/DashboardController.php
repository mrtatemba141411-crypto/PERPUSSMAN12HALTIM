<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kunjungan;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index', [
            'totalJudul' => Buku::count(),
            'totalStok' => Buku::sum('stok'),
            'totalAnggota' => Anggota::count(),
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'kunjunganHariIni' => Kunjungan::whereDate('scanned_at', today())->count(),
            'peminjamanTerbaru' => Peminjaman::with('buku')->latest()->take(5)->get(),
        ]);
    }
}
