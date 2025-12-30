@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Pelanggan</h1>
        <p class="page-subtitle">{{ $pelanggan->nama }}</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Alamat (Jalan/Gang)</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $pelanggan->alamat) }}" required>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">RT</label>
                    <input type="text" name="rt" class="form-control" value="{{ old('rt', $pelanggan->rt) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">RW</label>
                    <input type="text" name="rw" class="form-control" value="{{ old('rw', $pelanggan->rw) }}">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Dusun</label>
                    <input type="text" name="dusun" class="form-control" value="{{ old('dusun', $pelanggan->dusun) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Desa/Kelurahan</label>
                    <input type="text" name="desa" class="form-control" value="{{ old('desa', $pelanggan->desa) }}">
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $pelanggan->kecamatan) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kab/Kota</label>
                    <input type="text" name="kab_kota" class="form-control" value="{{ old('kab_kota', $pelanggan->kab_kota) }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP/WhatsApp</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $pelanggan->no_hp) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Iuran Bulanan (Rp)</label>
                <input type="number" name="iuran_bulanan" class="form-control" value="{{ old('iuran_bulanan', $pelanggan->iuran_bulanan) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="aktif" {{ $pelanggan->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ $pelanggan->status === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Update
                </button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
