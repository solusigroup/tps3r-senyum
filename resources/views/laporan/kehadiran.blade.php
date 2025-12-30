@extends('layouts.app')

@section('title', 'Laporan Kehadiran Karyawan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Laporan Kehadiran Karyawan</h1>
        <p class="page-subtitle">Filter dan lihat data kehadiran karyawan</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button onclick="window.print()" class="btn btn-secondary"><i data-lucide="printer"></i> Cetak</button>
        <a href="{{ route('laporan.kehadiran.pdf', request()->all()) }}" class="btn btn-primary"><i data-lucide="file-down"></i> PDF</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary"><i data-lucide="arrow-left"></i> Kembali</a>
    </div>
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('laporan.kehadiran') }}" method="GET">
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
                    <label class="form-label">Karyawan</label>
                    <select name="karyawan_id" class="form-control">
                        <option value="">-- Semua Karyawan --</option>
                        @foreach($karyawanList as $karyawan)
                            <option value="{{ $karyawan->id }}" {{ $request->karyawan_id == $karyawan->id ? 'selected' : '' }}>
                                {{ $karyawan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">-- Semua Status --</option>
                        <option value="Hadir" {{ $request->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ $request->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Sakit" {{ $request->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="Alpha" {{ $request->status == 'Alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="search"></i> Filter
                </button>
                <a href="{{ route('laporan.kehadiran') }}" class="btn btn-secondary" style="margin-left: 0.5rem;">
                    <i data-lucide="x"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary -->
<div class="grid-4" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Hadir</p>
            <h3>{{ $totalHadir }}</h3>
        </div>
        <div class="stat-icon green">
            <i data-lucide="check-circle"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Izin</p>
            <h3>{{ $totalIzin }}</h3>
        </div>
        <div class="stat-icon blue">
            <i data-lucide="file-text"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Sakit</p>
            <h3>{{ $totalSakit }}</h3>
        </div>
        <div class="stat-icon orange">
            <i data-lucide="thermometer"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Alpha</p>
            <h3>{{ $totalAlpha }}</h3>
        </div>
        <div class="stat-icon purple">
            <i data-lucide="x-circle"></i>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Data Kehadiran</h4>
        <span class="badge badge-info">{{ $data->count() }} data</span>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Karyawan</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td style="font-weight: 600;">{{ $item->karyawan->nama ?? '-' }}</td>
                    <td>
                        @if($item->status == 'Hadir')
                            <span class="badge badge-success">Hadir</span>
                        @elseif($item->status == 'Izin')
                            <span class="badge badge-info">Izin</span>
                        @elseif($item->status == 'Sakit')
                            <span class="badge badge-warning">Sakit</span>
                        @else
                            <span class="badge badge-danger">Alpha</span>
                        @endif
                    </td>
                    <td>{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
                    <td>{{ $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Tidak ada data kehadiran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
