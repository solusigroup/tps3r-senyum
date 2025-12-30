@extends('laporan.pdf.layout')

@section('report_title', 'Laporan Kehadiran Karyawan')

@section('content')
<div class="summary">
    <div class="summary-box">
        <div class="label">Hadir</div>
        <div class="value text-green">{{ $totalHadir }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Izin</div>
        <div class="value">{{ $totalIzin }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Sakit</div>
        <div class="value">{{ $totalSakit }}</div>
    </div>
    <div class="summary-box">
        <div class="label">Alpha</div>
        <div class="value text-red">{{ $totalAlpha }}</div>
    </div>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Karyawan</th>
            <th class="text-center">Status</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal->format('d/m/Y') }}</td>
            <td>{{ $item->karyawan->nama ?? '-' }}</td>
            <td class="text-center">
                @if($item->status == 'Hadir')
                    <span class="badge badge-success">Hadir</span>
                @elseif($item->status == 'Izin')
                    <span class="badge badge-info">Izin</span>
                @elseif($item->status == 'Sakit')
                    <span class="badge badge-warning">Sakit</span>
                @else
                    <span class="badge badge-danger">Alpha</span>
                @endif
            </td>
            <td>{{ $item->jam_masuk ? \Carbon\Carbon::parse($item->jam_masuk)->format('H:i') : '-' }}</td>
            <td>{{ $item->jam_keluar ? \Carbon\Carbon::parse($item->jam_keluar)->format('H:i') : '-' }}</td>
            <td>{{ $item->keterangan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
