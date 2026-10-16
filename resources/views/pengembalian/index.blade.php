@extends('layout')
@section('title', 'Pengembalian · Perpustakaan Kita')
@section('content')
<div class="heading"><div><h1>Pengembalian buku</h1><p class="sub">Catat dan kelola buku yang sudah dikembalikan.</p></div></div>

<h2 style="font-size:20px">Menunggu dikembalikan</h2>
<div class="card" style="margin-bottom:28px"><table><thead><tr><th>Buku</th><th>Peminjam</th><th>Tanggal pinjam</th><th>Rencana kembali</th><th>Catat pengembalian</th></tr></thead><tbody>
@forelse($belumKembali as $item)
<tr><td><strong>{{ $item->buku->judul }}</strong></td><td>{{ $item->nama_peminjam }}</td><td>{{ $item->tanggal_pinjam->format('d M Y') }}</td><td>{{ $item->tanggal_kembali?->format('d M Y') ?: '—' }}</td><td><form method="POST" action="{{ route('pengembalian.store', $item) }}" class="actions">@csrf<input aria-label="Tanggal dikembalikan" type="date" name="tanggal_dikembalikan" value="{{ old('tanggal_dikembalikan', date('Y-m-d')) }}" min="{{ $item->tanggal_pinjam->toDateString() }}" max="{{ date('Y-m-d') }}" required style="max-width:165px;padding:8px"> <button class="btn">Catat kembali</button></form>@error('tanggal_dikembalikan')<div class="error-text">{{ $message }}</div>@enderror</td></tr>
@empty<tr><td colspan="5" class="empty">Tidak ada peminjaman yang menunggu pengembalian.</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $belumKembali->links() }}</div></div>

<h2 style="font-size:20px">Riwayat pengembalian</h2>
<div class="card"><table><thead><tr><th>Buku</th><th>Peminjam</th><th>Tanggal pinjam</th><th>Tanggal dikembalikan</th><th>Aksi</th></tr></thead><tbody>
@forelse($sudahKembali as $item)
<tr><td><strong>{{ $item->buku->judul }}</strong></td><td>{{ $item->nama_peminjam }}</td><td>{{ $item->tanggal_pinjam->format('d M Y') }}</td><td><form class="actions" method="POST" action="{{ route('pengembalian.update', $item) }}">@csrf @method('PATCH')<input type="date" name="tanggal_dikembalikan" value="{{ $item->tanggal_dikembalikan?->toDateString() }}" min="{{ $item->tanggal_pinjam->toDateString() }}" max="{{ date('Y-m-d') }}" required aria-label="Tanggal dikembalikan" style="max-width:165px;padding:8px"><button class="btn light">Simpan tanggal</button></form></td><td><form method="POST" action="{{ route('pengembalian.destroy', $item) }}" onsubmit="return confirm('Batalkan catatan pengembalian ini? Stok buku akan dikurangi dan status kembali menjadi dipinjam.')">@csrf @method('DELETE')<button class="btn danger">Batalkan</button></form></td></tr>
@empty<tr><td colspan="5" class="empty">Belum ada catatan pengembalian.</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $sudahKembali->links() }}</div></div>
@endsection
