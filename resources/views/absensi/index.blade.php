@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Absensi Karyawan</h1>
        <p class="page-subtitle">Catat kehadiran harian</p>
    </div>
    <form action="{{ route('absensi.index') }}" method="GET" style="display: flex; gap: 0.75rem; align-items: center;">
        <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" onchange="this.form.submit()">
    </form>
</div>

<!-- Stats -->
<div class="grid-4" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-content">
            <p>Hadir</p>
            <h3 style="color: var(--emerald-600);">{{ $hadir }}</h3>
        </div>
        <div class="stat-icon green">
            <i data-lucide="check-circle"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Izin</p>
            <h3 style="color: #3b82f6;">{{ $izin }}</h3>
        </div>
        <div class="stat-icon blue">
            <i data-lucide="info"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Sakit</p>
            <h3 style="color: #f97316;">{{ $sakit }}</h3>
        </div>
        <div class="stat-icon orange">
            <i data-lucide="thermometer"></i>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-content">
            <p>Alpa</p>
            <h3 style="color: #ef4444;">{{ $alpa }}</h3>
        </div>
        <div class="stat-icon" style="background: #ef4444;">
            <i data-lucide="x-circle"></i>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            <i data-lucide="users" style="color: var(--emerald-600);"></i>
            Absensi {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}
        </h4>
    </div>
    <div class="card-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
            @foreach($karyawanAktif as $k)
            @php $abs = $absensi[$k->id] ?? null; @endphp
            <div style="padding: 1rem; background: var(--slate-50); border-radius: 0.75rem; display: flex; justify-content: space-between; align-items: center; {{ $abs ? 'border: 2px solid var(--emerald-200);' : '' }}">
                <div>
                    <p style="font-weight: 700; color: var(--slate-800);">{{ $k->nama }}</p>
                    <p style="font-size: 0.75rem; color: var(--slate-500);">{{ $k->jabatan }}</p>
                    @if($abs)
                    <span class="badge {{ $abs->status === 'Hadir' ? 'badge-success' : ($abs->status === 'Izin' ? 'badge-info' : ($abs->status === 'Sakit' ? 'badge-warning' : 'badge-danger')) }}" style="margin-top: 0.25rem;">
                        {{ $abs->status }}
                        @if($abs->jam_masuk) - {{ \Carbon\Carbon::parse($abs->jam_masuk)->format('H:i') }} @endif
                    </span>
                    @endif
                </div>
                <div style="display: flex; gap: 0.5rem;">
                    <form action="{{ route('absensi.cepat') }}" method="POST">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $k->id }}">
                        <input type="hidden" name="status" value="Hadir">
                        <button type="submit" class="btn btn-sm" style="background: var(--emerald-100); color: var(--emerald-700); {{ $abs?->status === 'Hadir' ? 'opacity: 0.5;' : '' }}">
                            <i data-lucide="check-circle-2" style="width: 16px; height: 16px;"></i>
                        </button>
                    </form>
                    <form action="{{ route('absensi.cepat') }}" method="POST">
                        @csrf
                        <input type="hidden" name="karyawan_id" value="{{ $k->id }}">
                        <input type="hidden" name="status" value="Alpa">
                        <button type="submit" class="btn btn-sm" style="background: #fef2f2; color: #dc2626; {{ $abs?->status === 'Alpa' ? 'opacity: 0.5;' : '' }}">
                            <i data-lucide="x-circle" style="width: 16px; height: 16px;"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        @if($karyawanAktif->isEmpty())
        <p style="text-align: center; color: var(--slate-400); padding: 2rem;">
            Belum ada karyawan aktif. <a href="{{ route('karyawan.create') }}">Tambah karyawan</a>
        </p>
        @endif
    </div>
</div>
@endsection
