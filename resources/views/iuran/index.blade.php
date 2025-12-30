@extends('layouts.app')

@section('title', 'Iuran Warga')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Iuran Warga</h1>
        <p class="page-subtitle">Kelola pembayaran iuran pelanggan</p>
    </div>
</div>

<!-- Stats -->
<div class="grid-2" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Belum Terbayar</p>
            <h3 style="color: #ef4444;">Rp {{ number_format($totalBelumBayar, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon" style="background: #ef4444;">
            <i data-lucide="alert-circle"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Total Lunas</p>
            <h3 style="color: var(--emerald-600);">Rp {{ number_format($totalLunas, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon green">
            <i data-lucide="check-circle"></i>
        </div>
    </div>
</div>

<div class="grid-3">
    <!-- Form Generate -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="calendar-plus" style="color: var(--emerald-600);"></i>
                Generate Tagihan Bulanan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('iuran.generate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-control" required>
                        <option value="Januari">Januari</option>
                        <option value="Februari">Februari</option>
                        <option value="Maret">Maret</option>
                        <option value="April">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Juni">Juni</option>
                        <option value="Juli">Juli</option>
                        <option value="Agustus">Agustus</option>
                        <option value="September">September</option>
                        <option value="Oktober">Oktober</option>
                        <option value="November">November</option>
                        <option value="Desember" {{ date('n') == 12 ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="zap"></i> Generate Tagihan
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card col-span-2">
        <div class="card-header">
            <h4 class="card-title">Daftar Tagihan</h4>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('iuran.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
                <a href="{{ route('iuran.index', ['status' => 'Belum Bayar']) }}" class="btn btn-sm {{ request('status') == 'Belum Bayar' ? 'btn-primary' : 'btn-secondary' }}">Belum Bayar</a>
                <a href="{{ route('iuran.index', ['status' => 'Lunas']) }}" class="btn btn-sm {{ request('status') == 'Lunas' ? 'btn-primary' : 'btn-secondary' }}">Lunas</a>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Warga</th>
                        <th>Alamat</th>
                        <th>Bulan</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($iuran as $item)
                    <tr>
                        <td style="font-weight: 600;">{{ $item->pelanggan->nama }}</td>
                        <td style="color: var(--slate-500);">{{ $item->pelanggan->alamat }}</td>
                        <td>{{ $item->bulan }} {{ $item->tahun }}</td>
                        <td style="font-weight: 500;">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $item->status === 'Lunas' ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            @if($item->status === 'Belum Bayar')
                            <form action="{{ route('iuran.lunas', $item) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Set Lunas</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                            Belum ada data iuran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($iuran->hasPages())
        <div class="card-body">
            {{ $iuran->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
