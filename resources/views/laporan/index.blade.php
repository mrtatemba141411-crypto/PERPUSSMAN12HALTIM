@extends('layout')
@section('title', 'Laporan · Perpustakaan SMAN 12 Halmahera Timur')
@section('content')
<div class="heading"><div><h1>Laporan perpustakaan</h1><p class="sub">Unduh laporan peminjaman dan pengembalian buku dalam PDF.</p></div></div>
<form class="card form-card" method="GET" action="{{ route('laporan.index') }}" style="max-width:760px;margin-bottom:24px">
    <h2 style="margin:0 0 4px;font-size:19px">Filter periode</h2>
    <div style="display:flex;gap:16px;flex-wrap:wrap">
        <div style="flex:1;min-width:220px"><label for="tanggal_mulai">Dari tanggal</label><input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">@error('tanggal_mulai')<div class="error-text">{{ $message }}</div>@enderror</div>
        <div style="flex:1;min-width:220px"><label for="tanggal_selesai">Sampai tanggal</label><input id="tanggal_selesai" type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">@error('tanggal_selesai')<div class="error-text">{{ $message }}</div>@enderror</div>
    </div>
    <button class="btn light" style="margin-top:18px">Terapkan periode</button>
</form>
<div class="stats"><div class="stat"><span>Periode</span><strong style="font-size:16px">{{ request('tanggal_mulai') ? \Illuminate\Support\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Semua' }} — {{ request('tanggal_selesai') ? \Illuminate\Support\Carbon::parse(request('tanggal_selesai'))->format('d/m/Y') : 'Sekarang' }}</strong></div></div>
<div style="display:flex;gap:14px;flex-wrap:wrap">
    <a class="btn" href="{{ route('laporan.peminjaman.pdf', request()->only('tanggal_mulai', 'tanggal_selesai')) }}">Unduh PDF Peminjaman</a>
    <a class="btn" href="{{ route('laporan.pengembalian.pdf', request()->only('tanggal_mulai', 'tanggal_selesai')) }}">Unduh PDF Pengembalian</a>
</div>
@endsection
