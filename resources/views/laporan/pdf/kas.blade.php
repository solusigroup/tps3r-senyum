@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Mutasi Kas (CMV)')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Total Masuk</div>
        <div class="value text-green">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Total Keluar</div>
        <div class="value text-red">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Saldo Akhir</div>
        <div class="value">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th class="text-center">Jenis</th>
            <th>Akun Lawan</th>
            <th>Keterangan</th>
            <th class="text-right">Masuk</th>
            <th class="text-right">Keluar</th>
            <th class="text-right">Saldo</th>
        </tr>
    </thead>
    <tbody>
        @php $saldoBerjalan = 0; @endphp
        @foreach($data as $index => $item)
        @php 
            if ($item->jenis == 'Masuk') {
                $saldoBerjalan += $item->jumlah;
            } else {
                $saldoBerjalan -= $item->jumlah;
            }
        @endphp
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
            <td class="text-center">
                <span class="badge {{ $item->jenis == 'Masuk' ? 'badge-success' : 'badge-danger' }}">{{ $item->jenis }}</span>
            </td>
            <td>{{ $item->akun_lawan }}</td>
            <td>{{ $item->keterangan }}</td>
            <td class="text-right text-green">{{ $item->jenis == 'Masuk' ? number_format($item->jumlah, 0, ',', '.') : '-' }}</td>
            <td class="text-right text-red">{{ $item->jenis == 'Keluar' ? number_format($item->jumlah, 0, ',', '.') : '-' }}</td>
            <td class="text-right font-bold">{{ number_format($saldoBerjalan, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right">TOTAL</td>
            <td class="text-right text-green">{{ number_format($totalMasuk, 0, ',', '.') }}</td>
            <td class="text-right text-red">{{ number_format($totalKeluar, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($saldoAkhir, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
@endsection
