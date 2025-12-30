@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Iuran')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Total Tagihan</div>
        <div class="value">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Lunas</div>
        <div class="value text-green">Rp {{ number_format($totalLunas, 0, ',', '.') }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Belum Lunas</div>
        <div class="value text-red">Rp {{ number_format($totalBelum, 0, ',', '.') }}</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Periode</th>
            <th class="text-right">Nominal</th>
            <th class="text-center">Status</th>
            <th>Tgl Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->pelanggan?->nama ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::create()->month((int)$item->bulan)->translatedFormat('F') }} {{ $item->tahun }}</td>
            <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
            <td class="text-center">
                <span class="badge {{ $item->status == 'Lunas' ? 'badge-success' : 'badge-danger' }}">{{ $item->status }}</span>
            </td>
            <td>{{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
