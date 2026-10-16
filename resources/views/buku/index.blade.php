@extends('layout')
@section('title', 'Katalog Buku · Perpustakaan Kita')
@section('content')
<div class="heading"><div><h1>Katalog buku</h1><p class="sub">Kelola koleksi buku perpustakaan.</p></div><a class="btn" href="{{ route('buku.create') }}">＋ Tambah buku</a></div>
<div class="stats"><div class="stat"><span>Judul buku</span><strong>{{ $totalBuku }}</strong></div><div class="stat"><span>Total stok tersedia</span><strong>{{ $totalStok }}</strong></div></div>
<form method="GET" action="{{ route('buku.index') }}" class="actions" style="margin-bottom:18px;max-width:720px"><input name="q" value="{{ $cari }}" placeholder="Cari judul, penulis, penerbit, atau ISBN..." aria-label="Cari buku"><button class="btn">Cari</button>@if($cari)<a class="btn light" href="{{ route('buku.index') }}">Reset</a>@endif</form>
<div class="card"><table><thead><tr><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
@forelse($buku as $item)<tr><td><strong>{{ $item->judul }}</strong><br><small>{{ $item->isbn ?: 'ISBN belum diisi' }}</small></td><td>{{ $item->penulis }}</td><td>{{ $item->penerbit ?: '—' }}</td><td>{{ $item->tahun_terbit ?: '—' }}</td><td>{{ $item->stok }}</td><td><div class="actions"><a class="btn light" href="{{ route('buku.edit', $item) }}">Edit</a><form method="POST" action="{{ route('buku.destroy', $item) }}" onsubmit="return confirm('Hapus buku ini?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="6" class="empty">{{ $cari ? 'Tidak ada buku yang cocok dengan pencarian.' : 'Belum ada buku. Tambahkan koleksi pertama Anda.' }}</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $buku->links() }}</div></div>
@endsection
