@extends('layout')
@section('title', ($buku->exists ? 'Edit' : 'Tambah').' Buku · Perpustakaan Kita')
@section('content')
<div class="heading"><div><h1>{{ $buku->exists ? 'Edit buku' : 'Tambah buku' }}</h1><p class="sub">Lengkapi informasi koleksi buku.</p></div><a class="btn light" href="{{ route('buku.index') }}">← Kembali</a></div>
<form class="card form-card" method="POST" action="{{ $buku->exists ? route('buku.update', $buku) : route('buku.store') }}">@csrf @if($buku->exists) @method('PUT') @endif
@foreach(['judul'=>'Judul buku','penulis'=>'Penulis','penerbit'=>'Penerbit','tahun_terbit'=>'Tahun terbit','isbn'=>'ISBN','stok'=>'Jumlah stok'] as $field=>$label)<label for="{{ $field }}">{{ $label }} @if(in_array($field, ['judul','penulis','stok']))* @endif</label><input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $buku->$field) }}" @if(in_array($field,['judul','penulis','stok'])) required @endif @if($field==='stok') type="number" min="0" @elseif($field==='tahun_terbit') type="number" min="1000" max="{{ date('Y')+1 }}" @else type="text" @endif>@error($field)<div class="error-text">{{ $message }}</div>@enderror @endforeach
<button class="btn" style="margin-top:22px">Simpan buku</button></form>
@endsection
