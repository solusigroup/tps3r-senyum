@extends('layouts.app')

@section('title', 'Laporan Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Pelanggan</h1>
        <p class="page-subtitle">Filter dan lihat data pelanggan</p>
    </div>
    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Kembali
    </a>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.pelanggan') }}" method="GET">
            <div class="grid-4">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua</option>
                        <option value="aktif" {{ $request->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $request->status == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" class="form-control" placeholder="RT" value="{{ $request->rt }}">
                </div>
                <div class="form-group">
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" class="form-control" placeholder="RW" value="{{ $request->rw }}">
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
            <p>Jumlah Pelanggan</p>
            <h3>{{ $data->count() }}</h3>
        </div>
        <div class="stat-icon blue"><i data-lucide="users"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Iuran Bulanan</p>
            <h3 style="color: var(--emerald-600);">Rp {{ number_format($totalIuran, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon green"><i data-lucide="wallet"></i></div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>RT/RW</th>
                    <th>Desa</th>
                    <th>No HP</th>
                    <th>Iuran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->rt }}/{{ $item->rw }}</td>
                    <td>{{ $item->desa ?? '-' }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td>Rp {{ number_format($item->iuran_bulanan, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $item->status == 'aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--slate-400); padding: 2rem;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
