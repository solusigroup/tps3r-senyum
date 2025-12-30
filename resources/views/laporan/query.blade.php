@extends('layouts.app')

@section('title', 'Query Builder')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Query Builder</h1>
        <p class="page-subtitle">Setting query custom dan filter dinamis</p>
    </div>
    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <i data-lucide="database" style="color: var(--emerald-600);"></i>
            Setting Query
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('laporan.query.execute') }}" method="POST">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Pilih Tabel/Modul</label>
                    <select name="table" class="form-control" required>
                        <option value="">-- Pilih Tabel --</option>
                        @foreach($tables as $key => $name)
                            <option value="{{ $key }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div></div>
            </div>

            <div class="grid-2" style="margin-top: 1rem;">
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai (opsional)</label>
                    <input type="date" name="tanggal_mulai" class="form-control">
                    <small style="color: var(--slate-400);">Berlaku untuk tabel dengan kolom tanggal</small>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Akhir (opsional)</label>
                    <input type="date" name="tanggal_akhir" class="form-control">
                </div>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--slate-200);">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="play"></i> Jalankan Query
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Info -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h4 class="card-title">Informasi Tabel</h4>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Tabel</th>
                    <th>Deskripsi</th>
                    <th>Filter Tersedia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Pengangkutan</strong></td>
                    <td>Data pengangkutan sampah harian</td>
                    <td>Tanggal, Wilayah</td>
                </tr>
                <tr>
                    <td><strong>Pemilahan</strong></td>
                    <td>Hasil pemilahan per kategori</td>
                    <td>Tanggal, Kategori</td>
                </tr>
                <tr>
                    <td><strong>Penjualan</strong></td>
                    <td>Transaksi penjualan hasil pilah</td>
                    <td>Tanggal, Jenis Barang</td>
                </tr>
                <tr>
                    <td><strong>Iuran</strong></td>
                    <td>Iuran bulanan warga</td>
                    <td>Bulan, Tahun, Status</td>
                </tr>
                <tr>
                    <td><strong>Pelanggan</strong></td>
                    <td>Data warga pelanggan</td>
                    <td>Status, RT/RW</td>
                </tr>
                <tr>
                    <td><strong>Karyawan</strong></td>
                    <td>Data karyawan TPS3R</td>
                    <td>Status, Jabatan</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
