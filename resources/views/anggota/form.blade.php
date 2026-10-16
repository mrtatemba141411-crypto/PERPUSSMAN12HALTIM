@extends('layout')
@section('title', ($anggota->exists ? 'Edit' : 'Tambah').' Anggota · Perpustakaan SMAN 12 Halmahera Timur')
@section('content')
<div class="heading"><div><h1>{{ $anggota->exists ? 'Edit anggota' : 'Tambah anggota' }}</h1><p class="sub">Isi informasi anggota perpustakaan.</p></div><a class="btn light" href="{{ route('anggota.index') }}">← Kembali</a></div>
<form class="card form-card" method="POST" action="{{ $anggota->exists ? route('anggota.update', $anggota) : route('anggota.store') }}">@csrf @if($anggota->exists) @method('PUT') @endif
<label for="nomor_anggota">Nomor anggota *</label><input id="nomor_anggota" name="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}" required maxlength="30">@error('nomor_anggota')<div class="error-text">{{ $message }}</div>@enderror
<label for="nama">Nama lengkap *</label><input id="nama" name="nama" value="{{ old('nama', $anggota->nama) }}" required maxlength="255">@error('nama')<div class="error-text">{{ $message }}</div>@enderror
<label for="jenis_kelamin">Jenis kelamin</label><select id="jenis_kelamin" name="jenis_kelamin"><option value="">Pilih (opsional)</option><option value="Laki-laki" @selected(old('jenis_kelamin', $anggota->jenis_kelamin)==='Laki-laki')>Laki-laki</option><option value="Perempuan" @selected(old('jenis_kelamin', $anggota->jenis_kelamin)==='Perempuan')>Perempuan</option></select>@error('jenis_kelamin')<div class="error-text">{{ $message }}</div>@enderror
<label for="alamat">Alamat</label><textarea id="alamat" name="alamat" rows="3" maxlength="2000">{{ old('alamat', $anggota->alamat) }}</textarea>@error('alamat')<div class="error-text">{{ $message }}</div>@enderror
<label for="no_hp">Nomor HP</label><input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $anggota->no_hp) }}" maxlength="30">@error('no_hp')<div class="error-text">{{ $message }}</div>@enderror
<label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email', $anggota->email) }}" maxlength="255">@error('email')<div class="error-text">{{ $message }}</div>@enderror
<button class="btn" style="margin-top:22px">Simpan anggota</button></form>
@endsection
