<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use chillerlan\QRCode\QRCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function index(): View
    {
        return view('anggota.index', [
            'anggota' => Anggota::latest()->paginate(10),
            'totalAnggota' => Anggota::count(),
        ]);
    }

    public function create(): View
    {
        return view('anggota.form', ['anggota' => new Anggota()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Anggota::create($this->validated($request));
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Anggota $anggota): View
    {
        return view('anggota.form', compact('anggota'));
    }

    public function qr(Anggota $anggota): View
    {
        return view('anggota.qr', [
            'anggota' => $anggota,
            'qr' => (new QRCode())->render('SMAN12-ANGGOTA:'.$anggota->nomor_anggota),
        ]);
    }

    public function update(Request $request, Anggota $anggota): RedirectResponse
    {
        $anggota->update($this->validated($request, $anggota));
        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Anggota $anggota): RedirectResponse
    {
        if ($anggota->kunjungan()->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena sudah memiliki riwayat kunjungan.');
        }
        $anggota->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

    private function validated(Request $request, ?Anggota $anggota = null): array
    {
        return $request->validate([
            'nomor_anggota' => ['required', 'string', 'max:30', Rule::unique('anggota', 'nomor_anggota')->ignore($anggota?->id)],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'alamat' => ['nullable', 'string', 'max:2000'],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('anggota', 'email')->ignore($anggota?->id)],
        ]);
    }
}
