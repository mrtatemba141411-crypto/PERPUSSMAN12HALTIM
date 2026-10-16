<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kunjungan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KunjunganController extends Controller
{
    public function index(): View
    {
        return view('pengunjung.index', [
            'kunjungan' => Kunjungan::with('anggota')->latest('scanned_at')->paginate(15),
            'kunjunganHariIni' => Kunjungan::whereDate('scanned_at', today())->count(),
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'payload' => ['nullable', 'string', 'max:255'],
            'nomor_anggota' => ['nullable', 'string', 'max:30'],
            'tujuan' => ['nullable', 'string', 'max:100'],
        ]);

        $payload = trim((string) ($request->input('payload') ?: $request->input('nomor_anggota')));
        $prefix = 'SMAN12-ANGGOTA:';
        $nomorAnggota = Str::startsWith($payload, $prefix) ? Str::after($payload, $prefix) : $payload;

        if ($nomorAnggota === '') {
            return $this->failure($request, 'QR atau nomor anggota belum diisi.');
        }

        $anggota = Anggota::where('nomor_anggota', $nomorAnggota)->first();
        if (! $anggota) {
            return $this->failure($request, 'Anggota tidak ditemukan. Pastikan QR berasal dari kartu anggota perpustakaan.');
        }

        $kunjungan = Kunjungan::create([
            'anggota_id' => $anggota->id,
            'tujuan' => $request->input('tujuan') ?: 'Kunjungan perpustakaan',
            'scanned_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Kunjungan berhasil dicatat.',
                'pengunjung' => [
                    'nomor_anggota' => $anggota->nomor_anggota,
                    'nama' => $anggota->nama,
                    'waktu' => $kunjungan->scanned_at->format('d/m/Y H:i'),
                    'tujuan' => $kunjungan->tujuan,
                ],
            ], 201);
        }

        return redirect()->route('pengunjung.index')->with('success', "Kunjungan {$anggota->nama} berhasil dicatat.");
    }

    private function failure(Request $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 422);
        }

        return back()->withInput()->with('error', $message);
    }
}
