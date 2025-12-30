@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">User Management</h1>
        <p class="page-subtitle">Kelola akun pengguna sistem</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i data-lucide="plus"></i> Tambah User
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="font-weight: 600;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'superuser' ? 'badge-danger' : ($user->role === 'administrasi' ? 'badge-info' : 'badge-warning') }}">
                            {{ $user->role_name }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-secondary btn-sm">Edit</a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h4 class="card-title">Keterangan Role</h4>
    </div>
    <div class="card-body">
        <div class="grid-3">
            <div style="padding: 1rem; background: #fef2f2; border-radius: 0.75rem;">
                <h5 style="color: #991b1b; font-weight: 700; margin-bottom: 0.5rem;">Superuser</h5>
                <p style="font-size: 0.875rem; color: #64748b;">Akses penuh ke semua fitur termasuk manajemen user.</p>
            </div>
            <div style="padding: 1rem; background: #dbeafe; border-radius: 0.75rem;">
                <h5 style="color: #1e40af; font-weight: 700; margin-bottom: 0.5rem;">Administrasi</h5>
                <p style="font-size: 0.875rem; color: #64748b;">Dapat mengelola data operasional (CRUD) tanpa akses manajemen user.</p>
            </div>
            <div style="padding: 1rem; background: #fef3c7; border-radius: 0.75rem;">
                <h5 style="color: #92400e; font-weight: 700; margin-bottom: 0.5rem;">Peninjau</h5>
                <p style="font-size: 0.875rem; color: #64748b;">Hanya dapat melihat laporan dan data, tidak bisa mengedit.</p>
            </div>
        </div>
    </div>
</div>
@endsection
