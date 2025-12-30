<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        $absensi = Absensi::with('karyawan')
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('karyawan_id');

        $karyawanAktif = Karyawan::where('status', 'aktif')->get();

        // Statistik
        $hadir = $absensi->where('status', 'Hadir')->count();
        $izin = $absensi->where('status', 'Izin')->count();
        $sakit = $absensi->where('status', 'Sakit')->count();
        $alpa = $absensi->where('status', 'Alpa')->count();

        return view('absensi.index', compact('absensi', 'karyawanAktif', 'tanggal', 'hadir', 'izin', 'sakit', 'alpa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_keluar' => 'nullable|date_format:H:i',
            'keterangan' => 'nullable|string',
        ]);

        Absensi::updateOrCreate(
            [
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $validated['tanggal'],
            ],
            $validated
        );

        return redirect()->route('absensi.index', ['tanggal' => $validated['tanggal']])
            ->with('success', 'Absensi berhasil dicatat.');
    }

    public function absenCepat(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        $tanggal = Carbon::today();

        Absensi::updateOrCreate(
            [
                'karyawan_id' => $validated['karyawan_id'],
                'tanggal' => $tanggal,
            ],
            [
                'status' => $validated['status'],
                'jam_masuk' => $validated['status'] === 'Hadir' ? Carbon::now()->format('H:i') : null,
            ]
        );

        return redirect()->route('absensi.index')
            ->with('success', 'Absensi berhasil dicatat.');
    }
}
