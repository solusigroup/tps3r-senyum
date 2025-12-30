@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Pemilahan')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Total Berat</div>
        <div class="value">{{ number_format($totalBerat, 1) }} Kg</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th class="text-right">Berat (Kg)</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
            <td>{{ $item->kategori }}</td>
            <td>{{ $item->jenis }}</td>
            <td class="text-right">{{ number_format($item->berat, 1) }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="text-right">TOTAL</td>
            <td class="text-right">{{ number_format($totalBerat, 1) }} Kg</td>
            <td></td>
        </tr>
    </tfoot>
</table>
@endsection
