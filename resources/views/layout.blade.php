<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan SMAN 12 Halmahera Timur')</title>
    <style>
        :root{font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:#15243a;background:#f0f0f0;font-size:15px;font-synthesis:none}*{box-sizing:border-box}body{margin:0}a{color:#3157a4}.app-shell{min-height:100vh}.sidebar{position:fixed;inset:0 auto 0 0;width:280px;background:#fff;padding:24px 20px;overflow-y:auto;border-right:1px solid #e6e8ed;z-index:5}.brand-box{display:flex;align-items:center;gap:10px;padding:10px 8px 28px;color:#315fbd}.brand-icon{font-size:30px;line-height:1}.brand{font-size:18px;font-weight:800;line-height:1.2;letter-spacing:-.4px}.brand small{display:block;color:#71809a;font-size:11px;letter-spacing:.04em;margin-top:4px}.nav-group{margin:0 0 18px}.nav-label{font-size:14px;color:#263a5d;padding:7px 10px 8px}.side-nav{display:grid;gap:4px}.side-nav a{display:flex;align-items:center;gap:12px;padding:11px 12px;border-radius:8px;color:#203a68;text-decoration:none;font-weight:550;transition:background .15s,color .15s}.side-nav a:hover{background:#eef2fc}.side-nav a.active{background:#435fc2;color:#fff;font-weight:700}.nav-icon{width:23px;text-align:center;color:#7488b4;font-size:17px}.side-nav a.active .nav-icon{color:#fff}.main-shell{margin-left:280px;min-height:100vh}.page-top{height:56px;padding:0 32px;display:flex;align-items:center;justify-content:space-between;gap:18px;background:#f7f7f8;border-bottom:1px solid #e6e8ed}.breadcrumb{display:flex;align-items:center;gap:10px;font-size:13px;color:#53627b}.breadcrumb a{font-weight:700;text-decoration:none;background:#435fc2;color:white;padding:5px 10px;border-radius:5px}.breadcrumb .slash{color:#95a0b2}.breadcrumb strong{font-weight:600;color:#18243a}.top-user{display:flex;align-items:center;gap:14px;color:#52617a;font-size:13px}.top-user form{margin:0}.top-user button{border:0;background:transparent;color:#3157a4;font:inherit;font-weight:650;cursor:pointer}.content{max-width:1500px;margin:0 auto;padding:26px 32px 12px}.heading{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-bottom:22px}h1{font-size:28px;margin:0 0 5px;letter-spacing:-.6px;color:#17263d}p.sub{margin:0;color:#71809a}.stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-bottom:22px}.stat,.card{background:#fff;border:1px solid #e5e7eb;border-radius:6px;box-shadow:0 2px 6px #17263d08}.stat{padding:18px 20px}.stat span{color:#71809a;font-size:13px}.stat strong{display:block;font-size:26px;margin-top:7px;color:#182b4b}.card{padding:0;overflow:hidden}.card-title{font-size:18px;font-weight:700;padding:18px 20px;background:#fafafa;border-bottom:1px solid #eee}.card-body{padding:20px}table{border-collapse:collapse;width:100%}th,td{text-align:left;padding:12px 14px;border-bottom:1px solid #e6e8ed}th{background:#e8e9eb;color:#24344d;font-size:12px}tr:last-child td{border-bottom:0}.btn{display:inline-block;border:0;border-radius:5px;padding:10px 14px;background:#168451;color:white;text-decoration:none;font:inherit;font-weight:650;cursor:pointer}.btn:hover{background:#116b42}.btn.light{background:#e9eefb;color:#3157a4}.btn.danger{background:#dc3545;color:white}.actions{display:flex;gap:8px;align-items:center}.actions form{margin:0}input,select,textarea{display:block;width:100%;padding:11px 12px;border:1px solid #ccd3df;border-radius:6px;font:inherit;background:white;color:#18243a}label{display:block;font-weight:650;margin:14px 0 6px}.form-card{padding:24px;max-width:760px}.flash{padding:12px 16px;border-radius:6px;background:#e5f5eb;color:#23643e;margin:0 0 18px}.flash.error{background:#fff0ee;color:#a53d30}.error-text{color:#a53d30;font-size:13px;margin-top:5px}.badge{display:inline-block;border-radius:99px;padding:5px 9px;font-size:12px;background:#fff2d8;color:#815910}.badge.done{background:#e4f4e9;color:#276641}.empty{padding:30px;text-align:center;color:#71809a}.pagination{padding:14px 16px}.pagination nav{display:flex;justify-content:space-between}.footer{color:#8791a1;text-align:center;font-size:12px;margin:28px 0 12px}.info-banner{padding:16px 18px;border-radius:5px;background:#54b1ec;color:white;margin-bottom:16px}.info-banner strong{font-size:18px;display:block;margin-bottom:4px}.info-banner p{margin:0}.dashboard-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}.quick-links{display:flex;gap:10px;flex-wrap:wrap}.guest-shell{min-height:100vh;display:grid;place-items:center;padding:24px;background:#f0f0f0}.guest-brand{position:absolute;top:28px;left:32px;color:#315fbd;font-weight:800;font-size:17px}.guest-brand small{display:block;color:#71809a;font-size:11px;margin-top:3px}.guest-shell>main{width:min(100%,460px)}@media(max-width:1000px){.sidebar{width:240px;padding:18px 14px}.main-shell{margin-left:240px}.content{padding:22px}.page-top{padding:0 22px}.stats{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:700px){.sidebar{position:static;width:auto;padding:10px 14px;border-right:0;border-bottom:1px solid #e6e8ed;max-height:none}.brand-box{padding:5px 6px 10px}.side-nav{display:flex;flex-wrap:wrap;gap:4px}.nav-group{margin:0 0 8px}.nav-label{display:none}.side-nav a{padding:8px 9px;font-size:13px}.nav-icon{width:auto}.main-shell{margin-left:0}.page-top{height:auto;min-height:52px;padding:10px 16px;flex-wrap:wrap}.content{padding:18px 14px}.stats{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.stat{padding:14px}.dashboard-grid{grid-template-columns:1fr}.heading{align-items:flex-start;flex-direction:column}.card{overflow-x:auto}table{min-width:650px}.guest-brand{position:static;margin-bottom:16px}.guest-shell{display:block;padding:20px}.guest-shell>main{margin:0 auto}}
        @media print{.sidebar,.page-top,.footer,.no-print{display:none!important}.main-shell{margin:0}.content{padding:0;max-width:none}body{background:#fff}}
    </style>
</head>
<body>
@auth
@php
    $currentPage = match (true) {
        request()->routeIs('dashboard') => 'Dashboard',
        request()->routeIs('buku.*') => 'Katalog Buku',
        request()->routeIs('anggota.*') => 'Anggota',
        request()->routeIs('pengunjung.*') => 'Pengunjung',
        request()->routeIs('peminjaman.*') => 'Peminjaman Buku',
        request()->routeIs('pengembalian.*') => 'Pengembalian Buku',
        request()->routeIs('laporan.*') => 'Laporan',
        default => 'Perpustakaan',
    };
@endphp
<div class="app-shell">
    <aside class="sidebar">
        <div class="brand-box"><span class="brand-icon">📚</span><div class="brand">SIPERPUS<small>SMAN 12 HALMAHERA TIMUR</small></div></div>
        <nav aria-label="Navigasi utama">
            <div class="nav-group"><div class="nav-label">Menu</div><div class="side-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="nav-icon">⌂</span>Dashboard</a>
            </div></div>
            <div class="nav-group"><div class="nav-label">Data Master</div><div class="side-nav">
                <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}"><span class="nav-icon">▣</span>Buku</a>
                <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}"><span class="nav-icon">◉</span>Anggota</a>
                <a href="{{ route('pengunjung.index') }}" class="{{ request()->routeIs('pengunjung.*') ? 'active' : '' }}"><span class="nav-icon">▤</span>Pengunjung</a>
            </div></div>
            <div class="nav-group"><div class="nav-label">Data Transaksi</div><div class="side-nav">
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}"><span class="nav-icon">⇧</span>Peminjaman Buku</a>
                <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'active' : '' }}"><span class="nav-icon">⇩</span>Pengembalian Buku</a>
            </div></div>
            <div class="nav-group"><div class="nav-label">Laporan</div><div class="side-nav">
                <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}"><span class="nav-icon">▤</span>Laporan</a>
            </div></div>
        </nav>
    </aside>
    <div class="main-shell">
        <header class="page-top"><div class="breadcrumb"><a href="{{ route('dashboard') }}">Dashboard</a><span class="slash">/</span><strong>{{ $currentPage }}</strong></div><div class="top-user"><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div></header>
        <main class="content">
            @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="flash error">{{ session('error') }}</div>@endif
            @yield('content')
            <div class="footer">PERPUSTAKAAN SMAN 12 HALMAHERA TIMUR · Kelola koleksi dan transaksi dengan mudah</div>
        </main>
    </div>
</div>
@else
<div class="guest-shell"><div class="guest-brand">📚 SIPERPUS<small>SMAN 12 HALMAHERA TIMUR</small></div><main>@yield('content')</main></div>
@endauth
</body>
</html>
