<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(\Illuminate\Http\Request $request): View
    {
        $cari = trim((string) $request->query('q', ''));
        $query = Buku::query();

        if ($cari !== '') {
            $query->where(function ($builder) use ($cari): void {
                $builder->where('judul', 'like', "%{$cari}%")
                    ->orWhere('penulis', 'like', "%{$cari}%")
                    ->orWhere('penerbit', 'like', "%{$cari}%")
                    ->orWhere('isbn', 'like', "%{$cari}%");
            });
        }

        return view('buku.index', [
            'buku' => $query->latest()->paginate(10)->withQueryString(),
            'cari' => $cari,
            'totalBuku' => Buku::count(),
            'totalStok' => Buku::sum('stok'),
        ]);
    }

    public function create(): View
    {
        return view('buku.form', ['buku' => new Buku()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Buku::create($this->validated($request));
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku): View
    {
        return view('buku.form', compact('buku'));
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $buku->update($this->validated($request));
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        if ($buku->peminjaman()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1000', 'max:'.(date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:30'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);
    }
}
