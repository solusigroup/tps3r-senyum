@extends('layouts.app')

@section('title', 'Jenis Barang')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Jenis Barang</h1>
        <p class="page-subtitle">Kelola kategori dan jenis barang untuk pemilahan & penjualan</p>
    </div>
</div>

<div class="grid-3">
    <!-- Form Input -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="plus" style="color: var(--emerald-600);"></i>
                Tambah Jenis Barang
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('jenis-barang.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Jenis</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Botol Plastik PET" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-control" required>
                        <option value="Organik">Organik</option>
                        <option value="Anorganik" selected>Anorganik</option>
                        <option value="Residu">Residu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Harga Default per Kg</label>
                    <input type="number" name="harga_default" class="form-control" placeholder="Rp 0" step="100">
                </div>
                <div class="form-group">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="kg" value="kg">
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Ringkasan -->
    <div class="card col-span-2">
        <div class="card-header">
            <h4 class="card-title">Ringkasan Jenis Barang</h4>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 150px; padding: 1rem; background: var(--emerald-50); border-radius: 0.75rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; color: var(--emerald-600);">{{ $ringkasan['Organik'] ?? 0 }}</div>
                    <div style="color: var(--slate-500);">Organik</div>
                </div>
                <div style="flex: 1; min-width: 150px; padding: 1rem; background: var(--blue-50); border-radius: 0.75rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; color: var(--blue-600);">{{ $ringkasan['Anorganik'] ?? 0 }}</div>
                    <div style="color: var(--slate-500);">Anorganik</div>
                </div>
                <div style="flex: 1; min-width: 150px; padding: 1rem; background: var(--red-50); border-radius: 0.75rem; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700; color: var(--red-600);">{{ $ringkasan['Residu'] ?? 0 }}</div>
                    <div style="color: var(--slate-500);">Residu</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h4 class="card-title">Daftar Jenis Barang</h4>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga Default</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisBarang as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama }}</td>
                    <td>
                        <span class="badge {{ $item->kategori === 'Organik' ? 'badge-success' : ($item->kategori === 'Anorganik' ? 'badge-info' : 'badge-danger') }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($item->harga_default, 0, ',', '.') }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>
                        <span class="badge {{ $item->aktif ? 'badge-success' : 'badge-secondary' }}">
                            {{ $item->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('jenis-barang.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus jenis barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada data jenis barang
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jenisBarang->hasPages())
    <div class="card-body">
        {{ $jenisBarang->links() }}
    </div>
    @endif
</div>
@endsection
