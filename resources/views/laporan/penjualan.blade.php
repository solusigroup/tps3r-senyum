@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Penjualan</h1>
        <p class="page-subtitle">Filter dan lihat data penjualan</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary"><i data-lucide="printer"></i> Cetak</button>
        <a href="{{ route('laporan.penjualan.pdf', request()->all()) }}" class="btn btn-primary"><i data-lucide="file-down"></i> PDF</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i data-lucide="arrow-left"></i> Kembali</a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.penjualan') }}" method="GET">
            <div class="grid-4">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $request->tanggal_mulai }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ $request->tanggal_akhir }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="form-control" placeholder="Cari jenis..." value="{{ $request->jenis_barang }}">
                </div>
                <div class="form-group" style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="search"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="grid-2" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Berat Terjual</p>
            <h3>{{ number_format($totalBerat, 1) }} Kg</h3>
            <p class="stat-sub">{{ $data->count() }} transaksi</p>
        </div>
        <div class="stat-icon blue"><i data-lucide="scale"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Pendapatan</p>
            <h3 style="color: var(--emerald-600);">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon green"><i data-lucide="banknote"></i></div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Barang</th>
                    <th>Berat</th>
                    <th>Harga/Kg</th>
                    <th>Total</th>
                    <th>Pembeli</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ $item->jenis_barang }}</td>
                    <td>{{ $item->berat }} Kg</td>
                    <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                    <td style="color: var(--emerald-600); font-weight: 700;">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->pembeli }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
