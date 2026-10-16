@extends('layout')
@section('title', 'Kartu QR Anggota · Perpustakaan SMAN 12 Halmahera Timur')
@section('content')
<div class="heading no-print"><div><h1>Kartu QR anggota</h1><p class="sub">QR ini digunakan untuk mencatat kunjungan anggota.</p></div><a class="btn light" href="{{ route('anggota.index') }}">← Kembali ke anggota</a></div>
<div class="card" style="max-width:460px;margin:0 auto;padding:28px;text-align:center">
    <h2 style="margin:0 0 6px">PERPUSTAKAAN SMAN 12</h2><p class="sub">HALMAHERA TIMUR</p>
    <img src="{{ $qr }}" alt="QR anggota {{ $anggota->nomor_anggota }}" width="240" height="240" style="margin:18px auto;display:block">
    <h2 style="margin:0">{{ $anggota->nama }}</h2><p style="margin:6px 0 0">Nomor anggota: <strong>{{ $anggota->nomor_anggota }}</strong></p>
    <button class="btn no-print" onclick="window.print()" style="margin-top:22px">Cetak kartu</button>
</div>
<style>@media print{.top,.footer,.no-print{display:none!important}main{margin:0;padding:0}.card{box-shadow:none;border:0}}</style>
@endsection
