@extends('layout')
@section('title', 'Pengunjung · Perpustakaan SMAN 12 Halmahera Timur')
@section('content')
<div class="heading"><div><h1>Data pengunjung</h1><p class="sub">Scan QR kartu anggota untuk mencatat kunjungan perpustakaan.</p></div></div>
<div class="stats"><div class="stat"><span>Kunjungan hari ini</span><strong>{{ $kunjunganHariIni }}</strong></div><div class="stat"><span>Total kunjungan</span><strong>{{ $kunjungan->total() }}</strong></div></div>
<div class="card form-card" style="max-width:760px;margin-bottom:24px;padding:24px">
    <h2 style="margin:0 0 4px;font-size:19px">Pemindai QR anggota</h2><p class="sub">Izinkan akses kamera, lalu arahkan kamera ke QR pada kartu anggota.</p>
    <label for="tujuan_scan">Tujuan kunjungan</label><select id="tujuan_scan"><option>Kunjungan perpustakaan</option><option>Membaca di perpustakaan</option><option>Mengembalikan buku</option><option>Meminjam buku</option><option>Lainnya</option></select>
    <div id="qr-reader" style="width:100%;max-width:480px;margin:16px auto 12px"></div>
    <button class="btn" type="button" id="start-scan">Mulai scan QR</button>
    <div id="scan-status" class="flash" role="status" aria-live="polite" style="margin-top:14px">Kamera belum diaktifkan.</div>
    <hr style="border:0;border-top:1px solid #e2ebe7;margin:22px 0">
    <form method="POST" action="{{ route('pengunjung.store') }}" class="actions" style="align-items:end;flex-wrap:wrap">@csrf
        <div style="flex:1;min-width:220px"><label for="nomor_anggota">Atau masukkan nomor anggota</label><input id="nomor_anggota" name="nomor_anggota" value="{{ old('nomor_anggota') }}" placeholder="Contoh: AGT-0001" required></div>
        <input type="hidden" name="tujuan" value="Kunjungan perpustakaan"><button class="btn light">Catat manual</button>
    </form>
</div>
<h2 style="font-size:20px">Riwayat kunjungan</h2>
<div class="card"><table><thead><tr><th>Waktu</th><th>No. anggota</th><th>Nama pengunjung</th><th>Tujuan</th></tr></thead><tbody>
@forelse($kunjungan as $item)<tr><td>{{ $item->scanned_at->format('d/m/Y H:i') }}</td><td>{{ $item->anggota->nomor_anggota }}</td><td><strong>{{ $item->anggota->nama }}</strong></td><td>{{ $item->tujuan }}</td></tr>
@empty<tr><td colspan="4" class="empty">Belum ada data kunjungan.</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $kunjungan->links() }}</div></div>
<script src="{{ asset('vendor/html5-qrcode/html5-qrcode.min.js') }}"></script>
<script>
(() => {
    const button = document.getElementById('start-scan');
    const status = document.getElementById('scan-status');
    const tujuan = document.getElementById('tujuan_scan');
    let scanner = null;
    let isSubmitting = false;

    button.addEventListener('click', async () => {
        if (typeof Html5Qrcode === 'undefined') {
            status.textContent = 'Pustaka pemindai QR belum dapat dimuat. Muat ulang halaman dan coba lagi.';
            return;
        }

        button.disabled = true;
        status.textContent = 'Meminta izin kamera…';
        scanner ??= new Html5Qrcode('qr-reader');

        try {
            await scanner.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                async (decodedText) => {
                    if (isSubmitting) return;
                    isSubmitting = true;
                    status.textContent = 'QR terbaca, menyimpan kunjungan…';
                    await scanner.stop().catch(() => {});

                    try {
                        const response = await fetch(@json(route('pengunjung.store')), {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: new URLSearchParams({ payload: decodedText, tujuan: tujuan.value }),
                        });
                        const result = await response.json();
                        if (!response.ok) throw new Error(result.message || 'Kunjungan gagal dicatat.');
                        status.textContent = `${result.message} ${result.pengunjung.nama} (${result.pengunjung.nomor_anggota}) — ${result.pengunjung.waktu}.`;
                        button.textContent = 'Scan pengunjung berikutnya';
                        setTimeout(() => window.location.reload(), 1300);
                    } catch (error) {
                        status.textContent = error.message;
                        button.disabled = false;
                        button.textContent = 'Coba scan lagi';
                        isSubmitting = false;
                    }
                },
                () => {}
            );
            status.textContent = 'Kamera aktif. Arahkan QR kartu anggota ke kotak pemindai.';
            button.textContent = 'Kamera aktif…';
        } catch (error) {
            status.textContent = 'Kamera tidak dapat dibuka. Periksa izin kamera atau gunakan input nomor anggota manual.';
            button.disabled = false;
            button.textContent = 'Coba lagi';
        }
    });
})();
</script>
@endsection
