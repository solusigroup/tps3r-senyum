@extends('layouts.app')

@section('title', 'Laporan Iuran')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Iuran</h1>
        <p class="page-subtitle">Filter dan lihat data iuran warga</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary"><i data-lucide="printer"></i> Cetak</button>
        <a href="{{ route('laporan.iuran.pdf', request()->all()) }}" class="btn btn-primary"><i data-lucide="file-down"></i> PDF</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i data-lucide="arrow-left"></i> Kembali</a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.iuran') }}" method="GET">
            <div class="grid-4">
                <div class="form-group">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-control">
                        <option value="">Semua</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $request->bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month((int)$i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-control">
                        <option value="">Semua</option>
                        @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                            <option value="{{ $y }}" {{ $request->tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua</option>
                        <option value="Lunas" {{ $request->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="Belum Lunas" {{ $request->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
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
<div class="grid-3" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Tagihan</p>
            <h3>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon blue"><i data-lucide="wallet"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Lunas</p>
            <h3 style="color: var(--emerald-600);">Rp {{ number_format($totalLunas, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon green"><i data-lucide="check-circle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Belum Lunas</p>
            <h3 style="color: #ef4444;">Rp {{ number_format($totalBelum, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon orange"><i data-lucide="alert-circle"></i></div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Periode</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->pelanggan?->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::create()->month((int)$item->bulan)->translatedFormat('F') }} {{ $item->tahun }}</td>
                    <td>Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $item->status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--slate-400); padding: 2rem;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
