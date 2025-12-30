@extends('layouts.app')

@section('title', 'Hasil Query')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Hasil Query: {{ ucfirst($table) }}</h1>
        <p class="page-subtitle">{{ $data->count() }} data ditemukan</p>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('laporan.query') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Kembali
        </a>
    </div>
</div>

@if($request->tanggal_mulai || $request->tanggal_akhir)
<div class="alert alert-success" style="margin-bottom: 1.5rem;">
    <i data-lucide="filter"></i>
    Filter aktif: 
    @if($request->tanggal_mulai) Dari {{ $request->tanggal_mulai }} @endif
    @if($request->tanggal_akhir) s/d {{ $request->tanggal_akhir }} @endif
</div>
@endif

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Data {{ ucfirst($table) }}</h4>
    </div>
    <div class="card-body" style="padding: 0; overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th>{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($data as $row)
                <tr>
                    @foreach($columns as $column)
                        <td>{{ $row->$column }}</td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($columns) }}" style="text-align: center; color: var(--slate-400); padding: 2rem;">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
