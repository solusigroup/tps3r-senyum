@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Karyawan</h1>
        <p class="page-subtitle">{{ $karyawan->nama }}</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('karyawan.update', $karyawan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $karyawan->nama) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">NIK</label>
                <input type="text" name="nik" class="form-control" value="{{ old('nik', $karyawan->nik) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Jabatan</label>
                <select name="jabatan" class="form-control" required>
                    <option value="Sopir" {{ $karyawan->jabatan === 'Sopir' ? 'selected' : '' }}>Sopir</option>
                    <option value="Pemilah" {{ $karyawan->jabatan === 'Pemilah' ? 'selected' : '' }}>Pemilah</option>
                    <option value="Petugas Kompos" {{ $karyawan->jabatan === 'Petugas Kompos' ? 'selected' : '' }}>Petugas Kompos</option>
                    <option value="Admin" {{ $karyawan->jabatan === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Koordinator" {{ $karyawan->jabatan === 'Koordinator' ? 'selected' : '' }}>Koordinator</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $karyawan->no_hp) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $karyawan->alamat) }}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk?->format('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ $karyawan->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $karyawan->status === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Update
                </button>
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
