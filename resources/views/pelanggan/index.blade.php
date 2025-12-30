@extends('layouts.app')

@section('title', 'Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pelanggan</h1>
        <p class="page-subtitle">Kelola data warga pelanggan TPS3R</p>
    </div>
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="{{ route('pelanggan.export') }}" class="btn btn-secondary">
            <i data-lucide="download"></i> Export Excel
        </a>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('importModal').style.display='flex'">
            <i data-lucide="upload"></i> Import Excel
        </button>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Tambah Pelanggan
        </a>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div class="card" style="max-width: 500px; width: 90%; margin: 0;">
        <div class="card-header">
            <h4 class="card-title">Import Data Pelanggan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pelanggan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <p style="font-size: 0.875rem; color: var(--slate-500); margin-bottom: 1rem;">
                    <a href="{{ route('pelanggan.template') }}" style="color: var(--emerald-600);">Download template</a> untuk format import yang benar.
                </p>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('importModal').style.display='none'" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Iuran/Bulan</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td>Rp {{ number_format($item->iuran_bulanan, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $item->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('pelanggan.edit', $item) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('pelanggan.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus pelanggan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada data pelanggan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pelanggan->hasPages())
    <div class="card-body">
        {{ $pelanggan->links() }}
    </div>
    @endif
</div>
@endsection
