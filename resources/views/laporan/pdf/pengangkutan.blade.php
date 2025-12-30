@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Pengangkutan')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Total Volume</div>
        <div class="value">{{ number_format($total, 1) }} Kg</div>
    </div>
    <div class="summary-box">
        <div class="label">Jumlah Data</div>
        <div class="value">{{ $data->count() }}</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Wilayah</th>
            <th class="text-right">Volume (Kg)</th>
            <th>Petugas</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
            <td>{{ $item->wilayah }}</td>
            <td class="text-right">{{ number_format($item->volume, 1) }}</td>
            <td>{{ $item->nama_petugas_display }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right">TOTAL</td>
            <td class="text-right">{{ number_format($total, 1) }} Kg</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>
@endsection
