@extends('layouts.app')

@section('title', 'Edit Transaksi Kas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Edit Transaksi Kas</h1>
        <p class="page-subtitle">Perbarui data transaksi kas</p>
    </div>
    <a href="{{ route('kas.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('kas.update', $kas) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Tanggal <span style="color: #ef4444;">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                           value="{{ old('tanggal', $kas->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Transaksi <span style="color: #ef4444;">*</span></label>
                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Masuk" {{ old('jenis', $kas->jenis) == 'Masuk' ? 'selected' : '' }}>Kas Masuk</option>
                        <option value="Keluar" {{ old('jenis', $kas->jenis) == 'Keluar' ? 'selected' : '' }}>Kas Keluar</option>
                    </select>
                    @error('jenis')
                        <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Akun Lawan <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="akun_lawan" class="form-control @error('akun_lawan') is-invalid @enderror" 
                           value="{{ old('akun_lawan', $kas->akun_lawan) }}" placeholder="Contoh: Pendapatan Penjualan" required>
                    @error('akun_lawan')
                        <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Jumlah (Rp) <span style="color: #ef4444;">*</span></label>
                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" 
                           value="{{ old('jumlah', $kas->jumlah) }}" placeholder="0" min="0" step="1" required>
                    @error('jumlah')
                        <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan <span style="color: #ef4444;">*</span></label>
                <input type="text" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                       value="{{ old('keterangan', $kas->keterangan) }}" placeholder="Deskripsi transaksi" required>
                @error('keterangan')
                    <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Bukti Transaksi</label>
                @if($kas->bukti)
                    <div style="margin-bottom: 0.75rem;">
                        <img src="{{ asset('storage/' . $kas->bukti) }}" alt="Bukti" 
                             style="max-width: 200px; max-height: 150px; border-radius: 0.5rem; border: 1px solid var(--slate-200);">
                        <p style="font-size: 0.75rem; color: var(--slate-500); margin-top: 0.25rem;">Bukti saat ini</p>
                    </div>
                @endif
                <input type="file" name="bukti" class="form-control @error('bukti') is-invalid @enderror" 
                       accept="image/*">
                <small style="color: var(--slate-500);">Kosongkan jika tidak ingin mengubah. Format: JPG, PNG, GIF. Maks 2MB.</small>
                @error('bukti')
                    <span style="color: #ef4444; font-size: 0.75rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('kas.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
