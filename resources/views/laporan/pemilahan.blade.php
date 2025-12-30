@extends('layouts.app')

@section('title', 'Laporan Pemilahan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Pemilahan</h1>
        <p class="page-subtitle">Filter dan lihat data pemilahan</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary"><i data-lucide="printer"></i> Cetak</button>
        <a href="{{ route('laporan.pemilahan.pdf', request()->all()) }}" class="btn btn-primary"><i data-lucide="file-down"></i> PDF</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i data-lucide="arrow-left"></i> Kembali</a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.pemilahan') }}" method="GET">
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
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control">
                        <option value="">Semua</option>
                        <option value="Organik" {{ $request->kategori == 'Organik' ? 'selected' : '' }}>Organik</option>
                        <option value="Anorganik" {{ $request->kategori == 'Anorganik' ? 'selected' : '' }}>Anorganik</option>
                        <option value="Residu" {{ $request->kategori == 'Residu' ? 'selected' : '' }}>Residu</option>
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
<div class="grid-4" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Berat</p>
            <h3>{{ number_format($totalBerat, 1) }} Kg</h3>
        </div>
        <div class="stat-icon green"><i data-lucide="scale"></i></div>
    </div>
    @foreach($ringkasan as $kategori => $berat)
    <div class="stat-card">
        <div class="stat-content">
            <p>{{ $kategori }}</p>
            <h3>{{ number_format($berat, 1) }} Kg</h3>
        </div>
    </div>
    @endforeach
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Data Pemilahan</h4>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Berat (Kg)</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $item->kategori == 'Organik' ? 'badge-success' : ($item->kategori == 'Anorganik' ? 'badge-info' : 'badge-danger') }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->berat }} Kg</td>
                    <td>{{ $item->karyawan?->nama ?? '-' }}</td>
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
