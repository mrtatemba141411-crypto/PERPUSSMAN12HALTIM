<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 28px 32px; }
        body { font-family: DejaVu Sans, sans-serif; color: #172b3a; font-size: 10px; }
        .header { text-align: center; border-bottom: 2px solid #123d34; padding-bottom: 12px; margin-bottom: 18px; }
        .header h1 { font-size: 18px; margin: 0 0 5px; color: #123d34; }
        .header h2 { font-size: 13px; margin: 0 0 5px; }
        .header p { margin: 0; color: #52615c; }
        .meta { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #cfd9d4; padding: 7px 6px; text-align: left; }
        th { background: #e8f2ee; color: #123d34; font-size: 9px; text-transform: uppercase; }
        td { vertical-align: top; }
        .center { text-align: center; }
        .empty { text-align: center; padding: 20px; color: #66746e; }
        .summary { margin-top: 10px; font-weight: bold; }
        .signature { margin-top: 35px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SMAN 12 HALMAHERA TIMUR</h1>
        <h2>LAPORAN DATA {{ strtoupper($jenis) }} BUKU</h2>
        <p>Periode: {{ $tanggalMulai ? \Illuminate\Support\Carbon::parse($tanggalMulai)->format('d/m/Y') : 'Semua tanggal' }} sampai {{ $tanggalSelesai ? \Illuminate\Support\Carbon::parse($tanggalSelesai)->format('d/m/Y') : 'Sekarang' }}</p>
    </div>
    <div class="meta">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</div>
    <table>
        <thead>
        @if($jenis === 'peminjaman')
            <tr><th class="center">No.</th><th>No. Peminjaman</th><th>Judul Buku</th><th>Penulis</th><th>Nama Peminjam</th><th>Tanggal Pinjam</th><th>Rencana Kembali</th><th>Status</th></tr>
        @else
            <tr><th class="center">No.</th><th>No. Peminjaman</th><th>Judul Buku</th><th>Penulis</th><th>Nama Peminjam</th><th>Tanggal Pinjam</th><th>Tanggal Dikembalikan</th><th>Rencana Kembali</th></tr>
        @endif
        </thead>
        <tbody>
        @forelse($data as $item)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td>PMJ-{{ str_pad((string) $item->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $item->buku->judul }}</td>
                <td>{{ $item->buku->penulis }}</td>
                <td>{{ $item->nama_peminjam }}</td>
                <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                @if($jenis === 'peminjaman')
                    <td>{{ $item->tanggal_kembali?->format('d/m/Y') ?: '—' }}</td>
                    <td>{{ ucfirst($item->status) }}</td>
                @else
                    <td>{{ ($item->tanggal_dikembalikan ?: $item->updated_at)->format('d/m/Y') }}</td>
                    <td>{{ $item->tanggal_kembali?->format('d/m/Y') ?: '—' }}</td>
                @endif
            </tr>
        @empty
            <tr><td colspan="8" class="empty">Tidak ada data pada periode ini.</td></tr>
        @endforelse
        </tbody>
    </table>
    <div class="summary">Jumlah data: {{ $data->count() }}</div>
    <div class="signature">Petugas Perpustakaan,<br><br><br>________________________</div>
</body>
</html>
