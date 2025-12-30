<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengangkutan;
use App\Models\Pemilahan;
use App\Models\Penjualan;
use App\Models\Iuran;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Kas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function pengangkutan(Request $request)
    {
        $query = Pengangkutan::with('karyawan');

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->wilayah) {
            $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
        }

        $data = $query->orderBy('tanggal', 'desc')->get();
        $total = $data->sum('volume');

        return view('laporan.pengangkutan', compact('data', 'total', 'request'));
    }

    public function pemilahan(Request $request)
    {
        $query = Pemilahan::with('karyawan');

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->jenis) {
            $query->where('jenis', 'like', '%' . $request->jenis . '%');
        }

        $data = $query->orderBy('tanggal', 'desc')->get();
        $totalBerat = $data->sum('berat');

        $ringkasan = $data->groupBy('kategori')->map(function ($items) {
            return $items->sum('berat');
        });

        return view('laporan.pemilahan', compact('data', 'totalBerat', 'ringkasan', 'request'));
    }

    public function penjualan(Request $request)
    {
        $query = Penjualan::query();

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->jenis_barang) {
            $query->where('jenis_barang', 'like', '%' . $request->jenis_barang . '%');
        }
        if ($request->pembeli) {
            $query->where('pembeli', 'like', '%' . $request->pembeli . '%');
        }

        $data = $query->orderBy('tanggal', 'desc')->get();
        $totalBerat = $data->sum('berat');
        $totalPendapatan = $data->sum('total');

        return view('laporan.penjualan', compact('data', 'totalBerat', 'totalPendapatan', 'request'));
    }

    public function iuran(Request $request)
    {
        $query = Iuran::with('pelanggan');

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $totalTagihan = $data->sum('nominal');
        $totalLunas = $data->where('status', 'Lunas')->sum('nominal');
        $totalBelum = $data->where('status', '!=', 'Lunas')->sum('nominal');

        return view('laporan.iuran', compact('data', 'totalTagihan', 'totalLunas', 'totalBelum', 'request'));
    }

    public function pelanggan(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->rt) {
            $query->where('rt', $request->rt);
        }
        if ($request->rw) {
            $query->where('rw', $request->rw);
        }
        if ($request->desa) {
            $query->where('desa', 'like', '%' . $request->desa . '%');
        }

        $data = $query->orderBy('nama')->get();
        $totalIuran = $data->sum('iuran_bulanan');

        return view('laporan.pelanggan', compact('data', 'totalIuran', 'request'));
    }

    public function kehadiran(Request $request)
    {
        $query = Absensi::with('karyawan');

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->karyawan_id) {
            $query->where('karyawan_id', $request->karyawan_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        // Get karyawan list for filter
        $karyawanList = Karyawan::where('status', 'aktif')->orderBy('nama')->get();

        // Summary
        $totalHadir = $data->where('status', 'Hadir')->count();
        $totalIzin = $data->where('status', 'Izin')->count();
        $totalSakit = $data->where('status', 'Sakit')->count();
        $totalAlpha = $data->where('status', 'Alpha')->count();

        return view('laporan.kehadiran', compact('data', 'karyawanList', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'request'));
    }

    public function kas(Request $request)
    {
        $query = Kas::query();

        if ($request->tanggal_mulai) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $data = $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();

        // Summary
        $totalMasuk = $data->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = $data->where('jenis', 'Keluar')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        return view('laporan.kas', compact('data', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'request'));
    }

    // Custom Query Builder
    public function query()
    {
        $tables = [
            'pengangkutan' => 'Pengangkutan',
            'pemilahan' => 'Pemilahan',
            'penjualan' => 'Penjualan',
            'iuran' => 'Iuran',
            'pelanggan' => 'Pelanggan',
            'karyawan' => 'Karyawan',
            'kas' => 'Kas',
        ];

        return view('laporan.query', compact('tables'));
    }

    public function queryExecute(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|in:pengangkutan,pemilahan,penjualan,iuran,pelanggan,karyawan,kas',
        ]);

        $table = $validated['table'];
        $query = DB::table($table);

        // Apply date filters if applicable
        if ($request->tanggal_mulai && in_array($table, ['pengangkutan', 'pemilahan', 'penjualan', 'kas'])) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_akhir && in_array($table, ['pengangkutan', 'pemilahan', 'penjualan', 'kas'])) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $data = $query->limit(500)->get();
        $columns = $data->isNotEmpty() ? array_keys((array) $data->first()) : [];

        return view('laporan.query-result', compact('data', 'columns', 'table', 'request'));
    }

    // PDF Export Methods
    public function pengangkutanPdf(Request $request)
    {
        $query = Pengangkutan::with('karyawan');
        if ($request->tanggal_mulai) $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        if ($request->tanggal_akhir) $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        if ($request->wilayah) $query->where('wilayah', 'like', '%' . $request->wilayah . '%');
        $data = $query->orderBy('tanggal', 'desc')->get();
        $total = $data->sum('volume');

        $pdf = Pdf::loadView('laporan.pdf.pengangkutan', compact('data', 'total', 'request'));
        return $pdf->download('laporan-pengangkutan.pdf');
    }

    public function pemilahanPdf(Request $request)
    {
        $query = Pemilahan::with('karyawan');
        if ($request->tanggal_mulai) $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        if ($request->tanggal_akhir) $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        if ($request->kategori) $query->where('kategori', $request->kategori);
        $data = $query->orderBy('tanggal', 'desc')->get();
        $totalBerat = $data->sum('berat');
        $ringkasan = $data->groupBy('kategori')->map(fn($items) => $items->sum('berat'));

        $pdf = Pdf::loadView('laporan.pdf.pemilahan', compact('data', 'totalBerat', 'ringkasan', 'request'));
        return $pdf->download('laporan-pemilahan.pdf');
    }

    public function penjualanPdf(Request $request)
    {
        $query = Penjualan::query();
        if ($request->tanggal_mulai) $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        if ($request->tanggal_akhir) $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        $data = $query->orderBy('tanggal', 'desc')->get();
        $totalBerat = $data->sum('berat');
        $totalPendapatan = $data->sum('total');

        $pdf = Pdf::loadView('laporan.pdf.penjualan', compact('data', 'totalBerat', 'totalPendapatan', 'request'));
        return $pdf->download('laporan-penjualan.pdf');
    }

    public function iuranPdf(Request $request)
    {
        $query = Iuran::with('pelanggan');
        if ($request->bulan) $query->where('bulan', $request->bulan);
        if ($request->tahun) $query->where('tahun', $request->tahun);
        if ($request->status) $query->where('status', $request->status);
        $data = $query->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        $totalTagihan = $data->sum('nominal');
        $totalLunas = $data->where('status', 'Lunas')->sum('nominal');
        $totalBelum = $data->where('status', '!=', 'Lunas')->sum('nominal');

        $pdf = Pdf::loadView('laporan.pdf.iuran', compact('data', 'totalTagihan', 'totalLunas', 'totalBelum', 'request'));
        return $pdf->download('laporan-iuran.pdf');
    }

    public function kehadiranPdf(Request $request)
    {
        $query = Absensi::with('karyawan');
        if ($request->tanggal_mulai) $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        if ($request->tanggal_akhir) $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        if ($request->karyawan_id) $query->where('karyawan_id', $request->karyawan_id);
        $data = $query->orderBy('tanggal', 'desc')->get();
        $totalHadir = $data->where('status', 'Hadir')->count();
        $totalIzin = $data->where('status', 'Izin')->count();
        $totalSakit = $data->where('status', 'Sakit')->count();
        $totalAlpha = $data->where('status', 'Alpha')->count();

        $pdf = Pdf::loadView('laporan.pdf.kehadiran', compact('data', 'totalHadir', 'totalIzin', 'totalSakit', 'totalAlpha', 'request'));
        return $pdf->download('laporan-kehadiran.pdf');
    }

    public function kasPdf(Request $request)
    {
        $query = Kas::query();
        if ($request->tanggal_mulai) $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        if ($request->tanggal_akhir) $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        $data = $query->orderBy('tanggal', 'asc')->get();
        $totalMasuk = $data->where('jenis', 'Masuk')->sum('jumlah');
        $totalKeluar = $data->where('jenis', 'Keluar')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('laporan.pdf.kas', compact('data', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'request'));
        return $pdf->download('laporan-kas.pdf');
    }
}
