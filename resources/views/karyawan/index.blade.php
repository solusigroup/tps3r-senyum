@extends('layouts.app')

@section('title', 'Karyawan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Karyawan</h1>
        <p class="page-subtitle">Kelola data karyawan TPS3R</p>
    </div>
    <a href="{{ route('karyawan.create') }}" class="btn btn-primary">
        <i data-lucide="plus"></i> Tambah Karyawan
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Jabatan</th>
                    <th>No. HP</th>
                    <th>Tgl Masuk</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawan as $item)
                <tr>
                    <td style="font-weight: 600;">{{ $item->nama }}</td>
                    <td>{{ $item->nik ?? '-' }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>{{ $item->no_hp ?? '-' }}</td>
                    <td>{{ $item->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $item->status === 'aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('karyawan.edit', $item) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('karyawan.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus karyawan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Belum ada data karyawan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
