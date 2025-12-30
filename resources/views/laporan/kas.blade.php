@extends('layouts.app')

@section('title', 'Laporan Kas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Mutasi Kas</h1>
        <p class="page-subtitle">Cash Mutation View (CMV)</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary"><i data-lucide="printer"></i> Cetak</button>
        <a href="{{ route('laporan.kas.pdf', request()->all()) }}" class="btn btn-primary"><i data-lucide="file-down"></i> PDF</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i data-lucide="arrow-left"></i> Kembali</a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.kas') }}" method="GET">
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
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-control">
                        <option value="">Semua</option>
                        <option value="Masuk" {{ $request->jenis == 'Masuk' ? 'selected' : '' }}>Kas Masuk</option>
                        <option value="Keluar" {{ $request->jenis == 'Keluar' ? 'selected' : '' }}>Kas Keluar</option>
                    </select>
                </div>
                <div class="form-group" style="display: flex; align-items: flex-end; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="search"></i> Filter
                    </button>
                    <a href="{{ route('laporan.kas') }}" class="btn btn-secondary">
                        <i data-lucide="x"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="grid-3" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Kas Masuk</p>
            <h3 style="color: var(--emerald-600);">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon green">
            <i data-lucide="arrow-down-circle"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Kas Keluar</p>
            <h3 style="color: #ef4444;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon orange">
            <i data-lucide="arrow-up-circle"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Saldo Akhir</p>
            <h3 style="color: {{ $saldoAkhir >= 0 ? 'var(--emerald-600)' : '#ef4444' }};">
                Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
            </h3>
        </div>
        <div class="stat-icon blue">
            <i data-lucide="wallet"></i>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detail Mutasi Kas</h4>
        <span class="badge badge-info">{{ $data->count() }} transaksi</span>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Akun Lawan</th>
                    <th>Keterangan</th>
                    <th style="text-align: right;">Masuk</th>
                    <th style="text-align: right;">Keluar</th>
                    <th style="text-align: right;">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @php $saldoBerjalan = 0; @endphp
                @forelse($data as $index => $item)
                @php 
                    if ($item->jenis == 'Masuk') {
                        $saldoBerjalan += $item->jumlah;
                    } else {
                        $saldoBerjalan -= $item->jumlah;
                    }
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>
                        @if($item->jenis == 'Masuk')
                            <span class="badge badge-success">Masuk</span>
                        @else
                            <span class="badge badge-danger">Keluar</span>
                        @endif
                    </td>
                    <td style="font-weight: 600;">{{ $item->akun_lawan }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td style="text-align: right; color: var(--emerald-600);">
                        {{ $item->jenis == 'Masuk' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '-' }}
                    </td>
                    <td style="text-align: right; color: #ef4444;">
                        {{ $item->jenis == 'Keluar' ? 'Rp ' . number_format($item->jumlah, 0, ',', '.') : '-' }}
                    </td>
                    <td style="text-align: right; font-weight: 600; color: {{ $saldoBerjalan >= 0 ? 'var(--slate-800)' : '#ef4444' }};">
                        Rp {{ number_format($saldoBerjalan, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Tidak ada data kas
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($data->count() > 0)
            <tfoot style="background: var(--slate-50); font-weight: 700;">
                <tr>
                    <td colspan="5" style="text-align: right;">TOTAL</td>
                    <td style="text-align: right; color: var(--emerald-600);">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
                    <td style="text-align: right; color: #ef4444;">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
                    <td style="text-align: right; color: {{ $saldoAkhir >= 0 ? 'var(--emerald-600)' : '#ef4444' }};">
                        Rp {{ number_format($saldoAkhir, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
