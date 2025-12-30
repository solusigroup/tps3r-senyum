<?php

namespace App\Http\Controllers;

use App\Models\Pengangkutan;
use App\Models\Penjualan;
use App\Models\Iuran;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Jadwal;
use App\Models\Pemilahan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->startOfMonth();
        $hariIni = Carbon::today();

        // Total sampah bulan ini
        $totalSampah = Pengangkutan::whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->sum('volume');

        // Total pendapatan penjualan
        $totalPendapatan = Penjualan::whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->sum('total');

        // Efisiensi Iuran
        $totalIuran = Iuran::whereYear('created_at', $bulanIni->year)->count();
        $iuranLunas = Iuran::whereYear('created_at', $bulanIni->year)->where('status', 'Lunas')->count();
        $efisiensiIuran = $totalIuran > 0 ? round(($iuranLunas / $totalIuran) * 100) : 0;

        // Kehadiran hari ini
        $totalKaryawan = Karyawan::where('status', 'aktif')->count();
        $hadirHariIni = Absensi::whereDate('tanggal', $hariIni)->where('status', 'Hadir')->count();

        // Pengangkutan terbaru
        $pengangkutanTerbaru = Pengangkutan::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Jadwal hari ini
        $hariIniNama = Carbon::now()->locale('id')->dayName;
        $jadwalHariIni = Jadwal::with('karyawan')
            ->where('hari', ucfirst($hariIniNama))
            ->orderBy('jam_mulai')
            ->get();

        // Ringkasan pemilahan bulan ini
        $ringkasanPemilahan = Pemilahan::selectRaw('kategori, SUM(berat) as total_berat')
            ->whereMonth('tanggal', $bulanIni->month)
            ->whereYear('tanggal', $bulanIni->year)
            ->groupBy('kategori')
            ->get()
            ->keyBy('kategori');

        return view('dashboard', compact(
            'totalSampah',
            'totalPendapatan',
            'efisiensiIuran',
            'totalKaryawan',
            'hadirHariIni',
            'pengangkutanTerbaru',
            'jadwalHariIni',
            'ringkasanPemilahan'
        ));
    }
}
