@extends('layouts.app')

@section('title', 'Pemilahan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pemilahan</h1>
        <p class="page-subtitle">Catat hasil pemilahan sampah</p>
    </div>
</div>

<div class="grid-2">
    <!-- Form Input -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="plus" style="color: var(--emerald-600);"></i>
                Input Hasil Pemilahan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pemilahan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Organik">Organik</option>
                        <option value="Anorganik">Anorganik</option>
                        <option value="Residu">Residu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <input type="text" name="jenis" class="form-control" placeholder="Plastik, Kertas, Logam, Kompos, dll" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" name="berat" step="0.1" class="form-control" placeholder="0.0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Petugas</label>
                    <select name="karyawan_id" class="form-control">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Ringkasan Hasil Pemilahan</h4>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 1rem; padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #22c55e;"></div>
                    <span style="font-weight: 500;">Organik</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasan['Organik']->total_berat ?? 0, 1) }} kg</span>
            </div>
            <div style="margin-bottom: 1rem; padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #3b82f6;"></div>
                    <span style="font-weight: 500;">Anorganik</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasan['Anorganik']->total_berat ?? 0, 1) }} kg</span>
            </div>
            <div style="padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #ef4444;"></div>
                    <span style="font-weight: 500;">Residu</span>
                </div>
                <span style="font-weight: 700;">{{ number_format($ringkasan['Residu']->total_berat ?? 0, 1) }} kg</span>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card" style="margin-top: 1.5rem;">
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
                    <th>Berat</th>
                    <th>Petugas</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemilahan as $item)
                <tr>
                    <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $item->kategori === 'Organik' ? 'badge-success' : ($item->kategori === 'Anorganik' ? 'badge-info' : 'badge-danger') }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->berat }} kg</td>
                    <td>{{ $item->karyawan?->nama ?? '-' }}</td>
                    <td style="text-align: center;">
                        <form action="{{ route('pemilahan.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
