<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LaporanController extends Controller
{
    public function index(): View
    {
        return view('laporan.index');
    }

    public function peminjamanPdf(Request $request): Response
    {
        $filters = $this->filters($request);
        $query = Peminjaman::with('buku')->orderBy('tanggal_pinjam')->orderBy('id');

        if ($filters['tanggal_mulai']) {
            $query->whereDate('tanggal_pinjam', '>=', $filters['tanggal_mulai']);
        }
        if ($filters['tanggal_selesai']) {
            $query->whereDate('tanggal_pinjam', '<=', $filters['tanggal_selesai']);
        }

        return Pdf::loadView('laporan.pdf', [
            'data' => $query->get(),
            'jenis' => 'peminjaman',
            'tanggalMulai' => $filters['tanggal_mulai'],
            'tanggalSelesai' => $filters['tanggal_selesai'],
        ])->setPaper('a4', 'landscape')->download($this->namaFile('peminjaman', $filters));
    }

    public function pengembalianPdf(Request $request): Response
    {
        $filters = $this->filters($request);
        $query = Peminjaman::with('buku')
            ->where('status', 'dikembalikan')
            ->orderByRaw('COALESCE(tanggal_dikembalikan, DATE(updated_at))')
            ->orderBy('id');

        if ($filters['tanggal_mulai']) {
            $query->whereRaw('COALESCE(tanggal_dikembalikan, DATE(updated_at)) >= ?', [$filters['tanggal_mulai']]);
        }
        if ($filters['tanggal_selesai']) {
            $query->whereRaw('COALESCE(tanggal_dikembalikan, DATE(updated_at)) <= ?', [$filters['tanggal_selesai']]);
        }

        return Pdf::loadView('laporan.pdf', [
            'data' => $query->get(),
            'jenis' => 'pengembalian',
            'tanggalMulai' => $filters['tanggal_mulai'],
            'tanggalSelesai' => $filters['tanggal_selesai'],
        ])->setPaper('a4', 'landscape')->download($this->namaFile('pengembalian', $filters));
    }

    private function filters(Request $request): array
    {
        $filters = $request->validate([
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        return [
            'tanggal_mulai' => $filters['tanggal_mulai'] ?? null,
            'tanggal_selesai' => $filters['tanggal_selesai'] ?? null,
        ];
    }

    private function namaFile(string $jenis, array $filters): string
    {
        $mulai = $filters['tanggal_mulai'] ?: 'awal';
        $selesai = $filters['tanggal_selesai'] ?: now()->format('Y-m-d');
        return "laporan-{$jenis}-{$mulai}-{$selesai}.pdf";
    }
}
