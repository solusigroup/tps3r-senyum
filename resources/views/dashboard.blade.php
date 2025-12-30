@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">TPS3R Senyum Desa Kedungmaling</p>
    </div>
</div>

<!-- Stat Cards -->
<div class="grid-4" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Sampah</p>
            <h3>{{ number_format($totalSampah, 1) }} m³</h3>
            <p class="stat-sub">Bulan ini</p>
        </div>
        <div class="stat-icon blue">
            <i data-lucide="truck"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <p>Hasil Penjualan</p>
            <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            <p class="stat-sub">Total pendapatan</p>
        </div>
        <div class="stat-icon green">
            <i data-lucide="banknote"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <p>Iuran Warga</p>
            <h3>{{ $efisiensiIuran }}%</h3>
            <p class="stat-sub">Efisiensi penagihan</p>
        </div>
        <div class="stat-icon orange">
            <i data-lucide="wallet"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-content">
            <p>Pekerja Hadir</p>
            <h3>{{ $hadirHariIni }} / {{ $totalKaryawan }}</h3>
            <p class="stat-sub">Hari ini</p>
        </div>
        <div class="stat-icon purple">
            <i data-lucide="users"></i>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid-3">
    <!-- Recent Activity -->
    <div class="card col-span-2">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="trending-up" style="color: var(--emerald-600);"></i>
                Aktivitas Pengangkutan Terbaru
            </h4>
            <a href="{{ route('pengangkutan.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Wilayah</th>
                        <th>Volume</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengangkutanTerbaru as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td style="font-weight: 600;">{{ $item->wilayah }}</td>
                        <td>{{ $item->volume }} m³</td>
                        <td>{{ $item->nama_petugas_display }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                            Belum ada data pengangkutan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="calendar" style="color: var(--emerald-600);"></i>
                Jadwal Hari Ini
            </h4>
        </div>
        <div class="card-body">
            @forelse($jadwalHariIni as $jadwal)
            <div class="schedule-item active">
                <div class="schedule-time">
                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}
                </div>
                <div class="schedule-info">
                    <h5>{{ $jadwal->wilayah }}</h5>
                    <p>{{ $jadwal->jenis_kegiatan }}</p>
                </div>
            </div>
            @empty
            <p style="color: var(--slate-400); text-align: center; padding: 1rem;">
                Tidak ada jadwal hari ini
            </p>
            @endforelse
        </div>
    </div>
</div>

<!-- Ringkasan Pemilahan -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h4 class="card-title">
            <i data-lucide="recycle" style="color: var(--emerald-600);"></i>
            Ringkasan Pemilahan Bulan Ini
        </h4>
    </div>
    <div class="card-body">
        <div class="grid-3">
            <div style="padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #22c55e;"></div>
                    <span style="font-weight: 500;">Organik (Kompos)</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasanPemilahan['Organik']->total_berat ?? 0, 1) }} kg</span>
            </div>
            <div style="padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #3b82f6;"></div>
                    <span style="font-weight: 500;">Anorganik (Terpilah)</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasanPemilahan['Anorganik']->total_berat ?? 0, 1) }} kg</span>
            </div>
            <div style="padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
                    <span style="font-weight: 500;">Residu</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasanPemilahan['Residu']->total_berat ?? 0, 1) }} kg</span>
            </div>
        </div>
    </div>
</div>
@endsection
