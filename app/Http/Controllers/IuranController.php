<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        $query = Iuran::with('pelanggan')->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $iuran = $query->paginate(20);
        $pelanggan = Pelanggan::where('status', 'aktif')->orderBy('nama')->get();

        // Statistik
        $totalBelumBayar = Iuran::where('status', 'Belum Bayar')->sum('jumlah');
        $totalLunas = Iuran::where('status', 'Lunas')->sum('jumlah');

        return view('iuran.index', compact('iuran', 'pelanggan', 'totalBelumBayar', 'totalLunas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'bulan' => 'required|string|max:50',
            'tahun' => 'required|integer|min:2020|max:2100',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $validated['status'] = 'Belum Bayar';

        Iuran::create($validated);

        return redirect()->route('iuran.index')
            ->with('success', 'Tagihan iuran berhasil dibuat.');
    }

    public function setLunas(Iuran $iuran)
    {
        $iuran->setLunas();

        return redirect()->route('iuran.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function generateBulanan(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);

        $pelangganAktif = Pelanggan::where('status', 'aktif')->get();

        $count = 0;
        foreach ($pelangganAktif as $pelanggan) {
            // Cek apakah sudah ada iuran untuk bulan ini
            $exists = Iuran::where('pelanggan_id', $pelanggan->id)
                ->where('bulan', $validated['bulan'])
                ->where('tahun', $validated['tahun'])
                ->exists();

            if (!$exists) {
                Iuran::create([
                    'pelanggan_id' => $pelanggan->id,
                    'bulan' => $validated['bulan'],
                    'tahun' => $validated['tahun'],
                    'jumlah' => $pelanggan->iuran_bulanan,
                    'status' => 'Belum Bayar',
                ]);
                $count++;
            }
        }

        return redirect()->route('iuran.index')
            ->with('success', "Tagihan bulanan berhasil dibuat untuk {$count} pelanggan.");
    }

    public function destroy(Iuran $iuran)
    {
        $iuran->delete();

        return redirect()->route('iuran.index')
            ->with('success', 'Data iuran berhasil dihapus.');
    }
}
