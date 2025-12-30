@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan</h1>
        <p class="page-subtitle">Pilih jenis laporan yang ingin ditampilkan</p>
    </div>
</div>

<div class="grid-3">
    <!-- Laporan Pengangkutan -->
    <a href="{{ route('laporan.pengangkutan') }}" class="card" style="text-decoration: none; transition: all 0.2s;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #3b82f6; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="truck" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Pengangkutan</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan pengangkutan per periode & wilayah</p>
        </div>
    </a>

    <!-- Laporan Pemilahan -->
    <a href="{{ route('laporan.pemilahan') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #22c55e; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="recycle" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Pemilahan</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan pemilahan per kategori & jenis</p>
        </div>
    </a>

    <!-- Laporan Penjualan -->
    <a href="{{ route('laporan.penjualan') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #f97316; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="banknote" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Penjualan</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan penjualan & pendapatan</p>
        </div>
    </a>

    <!-- Laporan Iuran -->
    <a href="{{ route('laporan.iuran') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #8b5cf6; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="wallet" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Iuran</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan iuran warga per status</p>
        </div>
    </a>

    <!-- Laporan Kehadiran -->
    <a href="{{ route('laporan.kehadiran') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #ec4899; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="calendar-check" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Kehadiran</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan kehadiran karyawan</p>
        </div>
    </a>

    <!-- Laporan Kas -->
    <a href="{{ route('laporan.kas') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: #06b6d4; border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="wallet" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Kas (CMV)</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Laporan mutasi kas masuk/keluar</p>
        </div>
    </a>

    <!-- Query Builder -->
    <a href="{{ route('laporan.query') }}" class="card" style="text-decoration: none;">
        <div class="card-body" style="text-align: center; padding: 2rem;">
            <div style="width: 64px; height: 64px; background: var(--slate-600); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                <i data-lucide="database" style="color: white; width: 32px; height: 32px;"></i>
            </div>
            <h4 style="font-weight: 700; color: var(--slate-800); margin-bottom: 0.5rem;">Query Builder</h4>
            <p style="color: var(--slate-500); font-size: 0.875rem;">Setting query custom & filter dinamis</p>
        </div>
    </a>
</div>
@endsection
