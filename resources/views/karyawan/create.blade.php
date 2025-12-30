@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Karyawan</h1>
        <p class="page-subtitle">Daftarkan karyawan baru</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="{{ old('nik') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="form-control" required>
                    <option value="Sopir">Sopir</option>
                    <option value="Pemilah">Pemilah</option>
                    <option value="Petugas Kompos">Petugas Kompos</option>
                    <option value="Admin">Admin</option>
                    <option value="Koordinator">Koordinator</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Simpan
                </button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
