@extends('layouts.app')

@section('title', 'Jadwal')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Jadwal Pengambilan</h1>
        <p class="page-subtitle">Kelola jadwal pengambilan sampah mingguan</p>
    </div>
</div>

<div class="grid-3">
    <!-- Form Input -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                <i data-lucide="plus" style="color: var(--emerald-600);"></i>
                Tambah Jadwal
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Hari</label>
                    <select name="hari" class="form-control" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Wilayah</label>
                    <input type="text" name="wilayah" class="form-control" placeholder="RW 01, RW 02, dll" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kegiatan</label>
                    <select name="jenis_kegiatan" class="form-control" required>
                        <option value="Pengambilan Sampah">Pengambilan Sampah</option>
                        <option value="Pemilahan">Pemilahan</option>
                        <option value="Pengomposan">Pengomposan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Petugas</label>
                    <select name="karyawan_id" class="form-control">
                        <option value="">-- Pilih Petugas --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i data-lucide="save"></i> Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- Jadwal Grid -->
    <div class="col-span-2">
        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
        <div class="card" style="margin-bottom: 1rem;">
            <div class="card-header" style="padding: 0.75rem 1rem; background: var(--slate-50);">
                <h4 class="card-title" style="font-size: 0.875rem;">{{ $hari }}</h4>
            </div>
            <div class="card-body" style="padding: 0;">
                @if(isset($jadwal[$hari]) && $jadwal[$hari]->isNotEmpty())
                <table class="table">
                    <tbody>
                        @foreach($jadwal[$hari] as $item)
                        <tr>
                            <td style="width: 80px; font-weight: 600; color: var(--emerald-600);">
                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                            </td>
                            <td style="font-weight: 600;">{{ $item->wilayah }}</td>
                            <td>{{ $item->jenis_kegiatan }}</td>
                            <td>{{ $item->karyawan?->nama ?? '-' }}</td>
                            <td style="text-align: right;">
                                <form action="{{ route('jadwal.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p style="padding: 1rem; color: var(--slate-400); text-align: center;">Tidak ada jadwal</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
