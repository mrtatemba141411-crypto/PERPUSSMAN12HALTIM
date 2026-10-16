<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function index(): View
    {
        return view('pengembalian.index', [
            'belumKembali' => Peminjaman::with('buku')->where('status', 'dipinjam')->latest()->paginate(8, ['*'], 'aktif'),
            'sudahKembali' => Peminjaman::with('buku')->where('status', 'dikembalikan')->latest()->paginate(8, ['*'], 'selesai'),
        ]);
    }

    public function store(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $data = $request->validate([
            'tanggal_dikembalikan' => ['required', 'date', 'after_or_equal:'.$peminjaman->tanggal_pinjam->toDateString(), 'before_or_equal:today'],
        ]);

        $berhasil = DB::transaction(function () use ($peminjaman, $data): bool {
            $pinjaman = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();
            if ($pinjaman->status !== 'dipinjam') {
                return false;
            }

            $pinjaman->update($data + ['status' => 'dikembalikan']);
            Buku::whereKey($pinjaman->buku_id)->increment('stok');
            return true;
        });

        return $berhasil
            ? back()->with('success', 'Pengembalian berhasil dicatat dan stok buku diperbarui.')
            : back()->with('error', 'Peminjaman ini sudah memiliki catatan pengembalian.');
    }

    public function update(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $data = $request->validate([
            'tanggal_dikembalikan' => ['required', 'date', 'after_or_equal:'.$peminjaman->tanggal_pinjam->toDateString(), 'before_or_equal:today'],
        ]);

        $diperbarui = Peminjaman::whereKey($peminjaman->id)
            ->where('status', 'dikembalikan')
            ->update($data);

        return $diperbarui
            ? back()->with('success', 'Tanggal pengembalian berhasil diperbarui.')
            : back()->with('error', 'Catatan pengembalian tidak ditemukan atau sudah dibatalkan.');
    }

    public function destroy(Peminjaman $peminjaman): RedirectResponse
    {
        $dibatalkan = DB::transaction(function () use ($peminjaman): bool {
            $pinjaman = Peminjaman::whereKey($peminjaman->id)->lockForUpdate()->firstOrFail();
            if ($pinjaman->status !== 'dikembalikan') {
                return false;
            }

            $buku = Buku::whereKey($pinjaman->buku_id)->lockForUpdate()->firstOrFail();
            if ($buku->stok < 1) {
                return false;
            }

            $buku->decrement('stok');
            $pinjaman->update(['status' => 'dipinjam', 'tanggal_dikembalikan' => null]);
            return true;
        });

        return $dibatalkan
            ? back()->with('success', 'Catatan pengembalian dibatalkan; buku kembali berstatus dipinjam.')
            : back()->with('error', 'Pengembalian tidak dapat dibatalkan. Periksa status dan stok buku.');
    }
}
