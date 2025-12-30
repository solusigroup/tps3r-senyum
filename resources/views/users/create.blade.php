@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Tambah User</h1>
        <p class="page-subtitle">Buat akun pengguna baru</p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')<span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')<span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="peninjau" {{ old('role') === 'peninjau' ? 'selected' : '' }}>Peninjau (View Only)</option>
                    <option value="administrasi" {{ old('role') === 'administrasi' ? 'selected' : '' }}>Administrasi (Kelola Data)</option>
                    <option value="superuser" {{ old('role') === 'superuser' ? 'selected' : '' }}>Superuser (Akses Penuh)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')<span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Simpan
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
