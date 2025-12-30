@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Penjualan Hasil Pilah</h1>
        <p class="page-subtitle">Catat penjualan ke pengepul</p>
    </div>
    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
        <a href="{{ route('penjualan.export') }}" class="btn btn-secondary">
            <i data-lucide="download"></i> Export
        </a>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('importModal').style.display='flex'">
            <i data-lucide="upload"></i> Import
        </button>
        <div style="background: var(--emerald-50); padding: 1rem 1.5rem; border-radius: 0.75rem; text-align: right;">
            <p style="color: var(--slate-500); font-size: 0.875rem;">Total Pendapatan</p>
            <h3 style="color: var(--emerald-700); font-size: 1.5rem; font-weight: 700;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div class="card" style="max-width: 500px; width: 90%; margin: 0;">
        <div class="card-header">
            <h4 class="card-title">Import Data Penjualan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penjualan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <p style="font-size: 0.875rem; color: var(--slate-500); margin-bottom: 1rem;">
                    <a href="{{ route('penjualan.template') }}" style="color: var(--emerald-600);">Download template</a> untuk format import yang benar.
                </p>
                <div style="display: flex; gap: 0.5rem;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('importModal').style.display='none'" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="grid-3">
    <!-- Form Input -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="banknote" style="color: var(--emerald-600);"></i>
                Input Penjualan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Barang</label>
                    <select name="jenis_barang" class="form-control" required>
                        <option value="Botol Plastik PET">Botol Plastik PET</option>
                        <option value="Kardus">Kardus</option>
                        <option value="Plastik Campur">Plastik Campur</option>
                        <option value="Besi/Logam">Besi/Logam</option>
                        <option value="Kertas Putih">Kertas Putih</option>
                        <option value="Aluminium">Aluminium</option>
                        <option value="Kompos">Kompos</option>
                    </select>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Berat (kg)</label>
                        <input type="number" name="berat" id="berat" step="0.1" class="form-control" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga /kg</label>
                        <input type="number" name="harga_per_kg" id="harga" class="form-control" placeholder="Rp" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Pembeli</label>
                    <input type="text" name="pembeli" class="form-control" placeholder="Nama Pengepul" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Catat Penjualan
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card col-span-2">
        <div class="card-header">
            <h4 class="card-title">Log Penjualan</h4>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th>Berat</th>
                        <th>Harga/kg</th>
                        <th>Total</th>
                        <th>Pembeli</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualan as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td style="font-weight: 600;">{{ $item->jenis_barang }}</td>
                        <td>{{ $item->berat }} kg</td>
                        <td>Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
                        <td style="color: var(--emerald-600); font-weight: 700;">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td>{{ $item->pembeli }}</td>
                        <td style="text-align: center;">
                            <form action="{{ route('penjualan.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                            Belum ada data penjualan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
