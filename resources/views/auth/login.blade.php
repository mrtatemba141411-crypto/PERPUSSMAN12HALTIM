@extends('layout')
@section('title', 'Masuk · Perpustakaan Kita')
@section('content')
<div style="max-width:440px;margin:55px auto 0">
    <div style="text-align:center;margin-bottom:24px"><div style="font-size:42px">📚</div><h1>Selamat datang</h1><p class="sub">Masuk untuk mengelola perpustakaan.</p></div>
    <form class="card form-card" method="POST" action="{{ route('login.authenticate') }}" style="max-width:none">@csrf
        <label for="username">Username</label><input id="username" name="username" value="{{ old('username') }}" autocomplete="username" required autofocus>@error('username')<div class="error-text">{{ $message }}</div>@enderror
        <label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required>@error('password')<div class="error-text">{{ $message }}</div>@enderror
        <label style="display:flex;align-items:center;gap:8px;font-weight:400"><input type="checkbox" name="remember" value="1" style="width:auto"> Ingat saya</label>
        <button class="btn" style="width:100%;margin-top:18px">Masuk</button>
    </form>
</div>
@endsection
