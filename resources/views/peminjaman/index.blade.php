@extends('layout')
@section('title', 'Peminjaman · Perpustakaan Kita')
@section('content')
<div class="heading"><div><h1>Peminjaman</h1><p class="sub">Catat buku yang dipinjam. Pengembalian dikelola di menu Pengembalian.</p></div></div>
<form class="card form-card" method="POST" action="{{ route('peminjaman.store') }}" style="margin-bottom:24px">@csrf<h2 style="margin:0 0 4px;font-size:19px">Peminjaman baru</h2>
<label for="buku_id">Pilih buku *</label><select id="buku_id" name="buku_id" required><option value="">Pilih buku yang tersedia</option>@foreach($buku as $item)<option value="{{ $item->id }}" @selected(old('buku_id')==$item->id)>{{ $item->judul }} — stok {{ $item->stok }}</option>@endforeach</select>@error('buku_id')<div class="error-text">{{ $message }}</div>@enderror
<label for="nama_peminjam">Nama peminjam *</label><input id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" required>@error('nama_peminjam')<div class="error-text">{{ $message }}</div>@enderror
<label for="tanggal_pinjam">Tanggal pinjam *</label><input id="tanggal_pinjam" type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>@error('tanggal_pinjam')<div class="error-text">{{ $message }}</div>@enderror
<label for="tanggal_kembali">Rencana tanggal kembali</label><input id="tanggal_kembali" type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}">@error('tanggal_kembali')<div class="error-text">{{ $message }}</div>@enderror
<button class="btn" style="margin-top:18px">Catat peminjaman</button></form>
<h2 style="font-size:20px">Riwayat peminjaman</h2><div class="card"><table><thead><tr><th>Buku</th><th>Peminjam</th><th>Tanggal pinjam</th><th>Rencana kembali</th><th>Status</th></tr></thead><tbody>
@forelse($peminjaman as $item)<tr><td><strong>{{ $item->buku->judul }}</strong></td><td>{{ $item->nama_peminjam }}</td><td>{{ $item->tanggal_pinjam->format('d M Y') }}</td><td>{{ $item->tanggal_kembali?->format('d M Y') ?: '—' }}</td><td><span class="badge {{ $item->status==='dikembalikan'?'done':'' }}">{{ ucfirst($item->status) }}</span></td></tr>
@empty<tr><td colspan="5" class="empty">Belum ada riwayat peminjaman.</td></tr>@endforelse</tbody></table><div class="pagination">{{ $peminjaman->links() }}</div></div>
@endsection
