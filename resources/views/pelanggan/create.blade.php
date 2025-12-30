@extends('layouts.app')

@section('title', 'Tambah Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Pelanggan</h1>
        <p class="page-subtitle">Daftarkan warga baru sebagai pelanggan</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat (Jalan/Gang)</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Contoh: Jl. Mawar No. 10" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt') }}" placeholder="001">
                </div>
                <div class="form-group">
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw') }}" placeholder="001">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Dusun</label>
                    <input type="text" name="dusun" class="form-control" value="{{ old('dusun') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Desa/Kelurahan</label>
                    <input type="text" name="desa" class="form-control" value="{{ old('desa') }}">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kab/Kota</label>
                    <input type="text" name="kab_kota" class="form-control" value="{{ old('kab_kota') }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP/WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Iuran Bulanan (Rp)</label>
                <input type="number" name="iuran_bulanan" class="form-control" value="{{ old('iuran_bulanan', 20000) }}" required>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Simpan
                </button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
