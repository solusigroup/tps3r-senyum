@extends('layouts.app')

@section('title', 'Kas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Kas</h1>
        <p class="page-subtitle">Kelola mutasi kas masuk dan keluar</p>
    </div>
    @if(auth()->user()->canManageData())
    <a href="{{ route('kas.create') }}" class="btn btn-primary">
        <i data-lucide="plus"></i> Tambah Transaksi
    </a>
    @endif
</div>

<!-- Filter -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="card-body">
        <form action="{{ route('kas.index') }}" method="GET">
            <div class="grid-4">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-control">
                        <option value="">Semua</option>
                        <option value="Masuk" {{ request('jenis') == 'Masuk' ? 'selected' : '' }}>Kas Masuk</option>
                        <option value="Keluar" {{ request('jenis') == 'Keluar' ? 'selected' : '' }}>Kas Keluar</option>
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
            <p>Saldo Kas</p>
            <h3>Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
        </div>
        <div class="stat-icon blue">
            <i data-lucide="wallet"></i>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Mutasi Kas</h4>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Akun Lawan</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Bukti</th>
                    @if(auth()->user()->canManageData())
                    <th>Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($kas as $item)
                <tr>
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
                    <td style="font-weight: 600; color: {{ $item->jenis == 'Masuk' ? 'var(--emerald-600)' : '#ef4444' }};">
                        {{ $item->jenis == 'Masuk' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($item->bukti)
                            <a href="{{ asset('storage/' . $item->bukti) }}" target="_blank" class="btn btn-sm btn-secondary">
                                <i data-lucide="image"></i>
                            </a>
                        @else
                            <span style="color: var(--slate-400);">-</span>
                        @endif
                    </td>
                    @if(auth()->user()->canManageData())
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="{{ route('kas.edit', $item) }}" class="btn btn-sm btn-secondary">
                                <i data-lucide="edit"></i>
                            </a>
                            <form action="{{ route('kas.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada data kas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div style="margin-top: 1rem;">
    {{ $kas->links() }}
</div>
@endsection
