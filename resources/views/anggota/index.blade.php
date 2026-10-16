@extends('layout')
@section('title', 'Anggota · Perpustakaan SMAN 12 Halmahera Timur')
@section('content')
<div class="heading"><div><h1>Data anggota</h1><p class="sub">Kelola data anggota perpustakaan.</p></div><a class="btn" href="{{ route('anggota.create') }}">＋ Tambah anggota</a></div>
<div class="stats"><div class="stat"><span>Total anggota</span><strong>{{ $totalAnggota }}</strong></div></div>
<div class="card"><table><thead><tr><th>No. anggota</th><th>Nama</th><th>Jenis kelamin</th><th>No. HP</th><th>Email</th><th>Aksi</th></tr></thead><tbody>
@forelse($anggota as $item)
<tr><td><strong>{{ $item->nomor_anggota }}</strong></td><td>{{ $item->nama }}</td><td>{{ $item->jenis_kelamin ?: '—' }}</td><td>{{ $item->no_hp ?: '—' }}</td><td>{{ $item->email ?: '—' }}</td><td><div class="actions"><a class="btn light" href="{{ route('anggota.qr', $item) }}">Kartu QR</a><a class="btn light" href="{{ route('anggota.edit', $item) }}">Edit</a><form method="POST" action="{{ route('anggota.destroy', $item) }}" onsubmit="return confirm('Hapus data anggota ini?')">@csrf @method('DELETE')<button class="btn danger">Hapus</button></form></div></td></tr>
@empty<tr><td colspan="6" class="empty">Belum ada anggota. Tambahkan data anggota pertama.</td></tr>@endforelse
</tbody></table><div class="pagination">{{ $anggota->links() }}</div></div>
@endsection
