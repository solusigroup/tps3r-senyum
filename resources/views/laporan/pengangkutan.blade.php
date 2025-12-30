@extends('layouts.app')

@section('title', 'Laporan Pengangkutan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Pengangkutan</h1>
        <p class="page-subtitle">Filter dan lihat data pengangkutan</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary">
            <i data-lucide="printer"></i> Cetak
        </button>
        <a href="{{ route('laporan.pengangkutan.pdf', request()->all()) }}" class="btn btn-primary">
            <i data-lucide="file-down"></i> PDF
        </a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.pengangkutan') }}" method="GET">
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
                    <label class="form-label">Wilayah</label>
                    <input type="text" name="wilayah" class="form-control" placeholder="Cari wilayah..." value="{{ $request->wilayah }}">
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
<div class="stat-card" style="margin-bottom: 1.5rem;">
    <div class="stat-content">
        <p>Total Berat Pengangkutan</p>
        <h3>{{ number_format($total, 1) }} Kg</h3>
        <p class="stat-sub">{{ $data->count() }} data ditemukan</p>
    </div>
    <div class="stat-icon blue">
        <i data-lucide="truck"></i>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Data Pengangkutan</h4>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Wilayah</th>
                    <th>Berat (Kg)</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ $item->wilayah }}</td>
                    <td>{{ $item->volume }} Kg</td>
                    <td>{{ $item->nama_petugas_display }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
