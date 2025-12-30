<?php

namespace App\Http\Controllers;

use App\Models\Pemilahan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class PemilahanController extends Controller
{
    public function index()
    {
        $pemilahan = Pemilahan::with('karyawan')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        $karyawan = Karyawan::where('status', 'aktif')->get();

        // Ringkasan per kategori
        $ringkasan = Pemilahan::selectRaw('kategori, SUM(berat) as total_berat')
            ->groupBy('kategori')
            ->get()
            ->keyBy('kategori');

        return view('pemilahan.index', compact('pemilahan', 'karyawan', 'ringkasan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:Organik,Anorganik,Residu',
            'jenis' => 'required|string|max:255',
            'berat' => 'required|numeric|min:0',
            'karyawan_id' => 'nullable|exists:karyawan,id',
            'keterangan' => 'nullable|string',
        ]);

        Pemilahan::create($validated);

        return redirect()->route('pemilahan.index')
            ->with('success', 'Data pemilahan berhasil disimpan.');
    }

    public function destroy(Pemilahan $pemilahan)
    {
        $pemilahan->delete();

        return redirect()->route('pemilahan.index')
            ->with('success', 'Data pemilahan berhasil dihapus.');
    }
}
