<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        return view('peminjaman.index', [
            'peminjaman' => Peminjaman::with('buku')->latest()->paginate(10),
            'buku' => Buku::where('stok', '>', 0)->orderBy('judul')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'buku_id' => ['required', 'exists:bukus,id'],
            'nama_peminjam' => ['required', 'string', 'max:255'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_kembali' => ['nullable', 'date', 'after_or_equal:tanggal_pinjam'],
        ]);

        DB::transaction(function () use ($data): void {
            $buku = Buku::whereKey($data['buku_id'])->lockForUpdate()->firstOrFail();
            if ($buku->stok < 1) {
                throw \Illuminate\Validation\ValidationException::withMessages(['buku_id' => 'Stok buku sedang habis.']);
            }
            $buku->decrement('stok');
            Peminjaman::create($data + ['status' => 'dipinjam']);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

}
