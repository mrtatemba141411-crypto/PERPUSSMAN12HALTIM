@extends('layout')

@section('title', 'Dashboard | SIPERPUS')

@section('content')
<div class="heading">
    <div><h1>⌂ Dashboard Perpustakaan</h1><p class="sub">Ringkasan aktivitas perpustakaan SMAN 12 Halmahera Timur.</p></div>
</div>

<div class="info-banner"><strong>Informasi</strong><p>Selamat datang di SIPERPUS. Kelola katalog, data anggota, kunjungan, serta transaksi peminjaman dan pengembalian melalui menu di samping.</p></div>

<section class="stats" aria-label="Ringkasan perpustakaan">
    <div class="stat"><span>Judul Buku</span><strong>{{ number_format($totalJudul) }}</strong></div>
    <div class="stat"><span>Total Stok Tersedia</span><strong>{{ number_format($totalStok) }}</strong></div>
    <div class="stat"><span>Anggota</span><strong>{{ number_format($totalAnggota) }}</strong></div>
    <div class="stat"><span>Sedang Dipinjam</span><strong>{{ number_format($sedangDipinjam) }}</strong></div>
</section>

<div class="dashboard-grid">
    <section class="card">
        <div class="card-title">⚡ Akses Cepat</div>
        <div class="card-body"><div class="quick-links">
            <a class="btn" href="{{ route('buku.index') }}">▣ Katalog Buku</a>
            <a class="btn" href="{{ route('peminjaman.index') }}">⇧ Catat Peminjaman</a>
            <a class="btn light" href="{{ route('pengunjung.index') }}">◉ Scan Kunjungan</a>
        </div></div>
    </section>
    <section class="card">
        <div class="card-title">◉ Kunjungan Hari Ini</div>
        <div class="card-body"><strong style="font-size:30px;color:#182b4b">{{ number_format($kunjunganHariIni) }}</strong><p class="sub">pengunjung tercatat melalui pemindaian QR atau input nomor anggota.</p></div>
    </section>
</div>

<section class="card" style="margin-top:18px">
    <div class="card-title">⇧ Peminjaman Terbaru</div>
    @if($peminjamanTerbaru->isEmpty())
        <div class="empty">Belum ada transaksi peminjaman.</div>
    @else
        <table><thead><tr><th>Nama Peminjam</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Status</th></tr></thead><tbody>
        @foreach($peminjamanTerbaru as $item)
            <tr><td>{{ $item->nama_peminjam }}</td><td>{{ $item->buku?->judul ?? 'Buku dihapus' }}</td><td>{{ $item->tanggal_pinjam?->format('d M Y') }}</td><td><span class="badge {{ $item->status === 'dikembalikan' ? 'done' : '' }}">{{ ucfirst($item->status) }}</span></td></tr>
        @endforeach
        </tbody></table>
    @endif
</section>
@endsection
