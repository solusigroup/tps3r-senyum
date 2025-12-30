@extends('layouts.app')

@section('title', 'Pengangkutan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Pengangkutan</h1>
        <p class="page-subtitle">Catat pengangkutan sampah harian</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('pengangkutan.export') }}" class="btn btn-secondary">
            <i data-lucide="download"></i> Export
        </a>
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('importModal').style.display='flex'">
            <i data-lucide="upload"></i> Import
        </button>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div class="card" style="max-width: 500px; width: 90%; margin: 0;">
        <div class="card-header">
            <h4 class="card-title">Import Data Pengangkutan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pengangkutan.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">File Excel (.xlsx, .xls, .csv)</label>
                    <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                </div>
                <p style="font-size: 0.875rem; color: var(--slate-500); margin-bottom: 1rem;">
                    <a href="{{ route('pengangkutan.template') }}" style="color: var(--emerald-600);">Download template</a> untuk format import yang benar.
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
                <i data-lucide="plus" style="color: var(--emerald-600);"></i>
                Input Data Pengangkutan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pengangkutan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Wilayah (RT/RW)</label>
                    <input type="text" name="wilayah" class="form-control" placeholder="Contoh: RT 05 / RW 02" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Berat (Kg)</label>
                    <input type="number" name="volume" step="0.1" class="form-control" placeholder="0.0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Petugas/Sopir</label>
                    <select name="karyawan_id" class="form-control">
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }} ({{ $k->jabatan }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Atau Nama Manual</label>
                    <input type="text" name="nama_petugas" class="form-control" placeholder="Nama Petugas (jika tidak ada di daftar)">
                </div>
                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Simpan Data
                </button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card col-span-2">
        <div class="card-header">
            <h4 class="card-title">History Pengangkutan</h4>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Wilayah</th>
                        <th>Volume</th>
                        <th>Petugas</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengangkutan as $item)
                    <tr>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td style="font-weight: 600;">{{ $item->wilayah }}</td>
                        <td>{{ $item->volume }} Kg</td>
                        <td>{{ $item->nama_petugas_display }}</td>
                        <td style="text-align: center;">
                            <form action="{{ route('pengangkutan.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                            Belum ada data
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengangkutan->hasPages())
        <div class="card-body" style="padding: 1rem;">
            {{ $pengangkutan->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
