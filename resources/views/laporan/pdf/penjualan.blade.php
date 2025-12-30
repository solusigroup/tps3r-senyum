@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Penjualan')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Total Berat</div>
        <div class="value">{{ number_format($totalBerat, 1) }} Kg</div>
    </div>
    <div class="summary-box">
        <div class="label">Total Pendapatan</div>
        <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Jenis Barang</th>
            <th class="text-right">Berat (Kg)</th>
            <th class="text-right">Harga/Kg</th>
            <th class="text-right">Total</th>
            <th>Pembeli</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
            <td>{{ $item->jenis_barang }}</td>
            <td class="text-right">{{ number_format($item->berat, 1) }}</td>
            <td class="text-right">{{ number_format($item->harga_per_kg, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->total, 0, ',', '.') }}</td>
            <td>{{ $item->pembeli ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right">TOTAL</td>
            <td class="text-right">{{ number_format($totalBerat, 1) }} Kg</td>
            <td></td>
            <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
@endsection
