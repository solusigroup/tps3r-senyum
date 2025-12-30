<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with('karyawan')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $karyawan = Karyawan::where('status', 'aktif')->get();

        return view('jadwal.index', compact('jadwal', 'karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'wilayah' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'keterangan' => 'nullable|string',
        ]);

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $karyawan = Karyawan::where('status', 'aktif')->get();
        return view('jadwal.edit', compact('jadwal', 'karyawan'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'wilayah' => 'required|string|max:255',
            'jenis_kegiatan' => 'required|string|max:255',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal->update($validated);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
