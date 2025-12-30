<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengangkutanController;
use App\Http\Controllers\PemilahanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\IuranController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KasController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes - Require Authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard - All authenticated users can view
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // View Routes - All authenticated users can view reports/data
    Route::get('/pengangkutan', [PengangkutanController::class, 'index'])->name('pengangkutan.index');
    Route::get('/pemilahan', [PemilahanController::class, 'index'])->name('pemilahan.index');
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/iuran', [IuranController::class, 'index'])->name('iuran.index');
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang.index');
    Route::get('/kas', [KasController::class, 'index'])->name('kas.index');
    
    // Laporan Routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pengangkutan', [LaporanController::class, 'pengangkutan'])->name('pengangkutan');
        Route::get('/pemilahan', [LaporanController::class, 'pemilahan'])->name('pemilahan');
        Route::get('/penjualan', [LaporanController::class, 'penjualan'])->name('penjualan');
        Route::get('/iuran', [LaporanController::class, 'iuran'])->name('iuran');
        Route::get('/pelanggan', [LaporanController::class, 'pelanggan'])->name('pelanggan');
        Route::get('/kehadiran', [LaporanController::class, 'kehadiran'])->name('kehadiran');
        Route::get('/kas', [LaporanController::class, 'kas'])->name('kas');
        Route::get('/query', [LaporanController::class, 'query'])->name('query');
        Route::post('/query', [LaporanController::class, 'queryExecute'])->name('query.execute');
        
        // PDF Export Routes
        Route::get('/pengangkutan/pdf', [LaporanController::class, 'pengangkutanPdf'])->name('pengangkutan.pdf');
        Route::get('/pemilahan/pdf', [LaporanController::class, 'pemilahanPdf'])->name('pemilahan.pdf');
        Route::get('/penjualan/pdf', [LaporanController::class, 'penjualanPdf'])->name('penjualan.pdf');
        Route::get('/iuran/pdf', [LaporanController::class, 'iuranPdf'])->name('iuran.pdf');
        Route::get('/kehadiran/pdf', [LaporanController::class, 'kehadiranPdf'])->name('kehadiran.pdf');
        Route::get('/kas/pdf', [LaporanController::class, 'kasPdf'])->name('kas.pdf');
    });
    
    // API for dropdown
    Route::get('/api/jenis-barang', [JenisBarangController::class, 'list'])->name('api.jenis-barang');

    // Data Management Routes - Only Superuser and Administrasi can manage
    Route::middleware(['can.manage'])->group(function () {
        // Pengangkutan
        Route::post('/pengangkutan', [PengangkutanController::class, 'store'])->name('pengangkutan.store');
        Route::get('/pengangkutan/{pengangkutan}/edit', [PengangkutanController::class, 'edit'])->name('pengangkutan.edit');
        Route::put('/pengangkutan/{pengangkutan}', [PengangkutanController::class, 'update'])->name('pengangkutan.update');
        Route::delete('/pengangkutan/{pengangkutan}', [PengangkutanController::class, 'destroy'])->name('pengangkutan.destroy');
        Route::get('/pengangkutan/export', [PengangkutanController::class, 'export'])->name('pengangkutan.export');
        Route::post('/pengangkutan/import', [PengangkutanController::class, 'import'])->name('pengangkutan.import');
        Route::get('/pengangkutan/template', [PengangkutanController::class, 'template'])->name('pengangkutan.template');

        // Pemilahan
        Route::post('/pemilahan', [PemilahanController::class, 'store'])->name('pemilahan.store');
        Route::delete('/pemilahan/{pemilahan}', [PemilahanController::class, 'destroy'])->name('pemilahan.destroy');

        // Penjualan
        Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.store');
        Route::delete('/penjualan/{penjualan}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
        Route::get('/penjualan/export', [PenjualanController::class, 'export'])->name('penjualan.export');
        Route::post('/penjualan/import', [PenjualanController::class, 'import'])->name('penjualan.import');
        Route::get('/penjualan/template', [PenjualanController::class, 'template'])->name('penjualan.template');

        // Pelanggan
        Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
        Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
        Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
        Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])->name('pelanggan.update');
        Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
        Route::get('/pelanggan/export', [PelangganController::class, 'export'])->name('pelanggan.export');
        Route::post('/pelanggan/import', [PelangganController::class, 'import'])->name('pelanggan.import');
        Route::get('/pelanggan/template', [PelangganController::class, 'template'])->name('pelanggan.template');

        // Iuran
        Route::post('/iuran', [IuranController::class, 'store'])->name('iuran.store');
        Route::post('/iuran/{iuran}/lunas', [IuranController::class, 'setLunas'])->name('iuran.lunas');
        Route::post('/iuran/generate', [IuranController::class, 'generateBulanan'])->name('iuran.generate');
        Route::delete('/iuran/{iuran}', [IuranController::class, 'destroy'])->name('iuran.destroy');

        // Karyawan
        Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
        Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
        Route::get('/karyawan/{karyawan}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
        Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
        Route::delete('/karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

        // Absensi
        Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::post('/absensi/cepat', [AbsensiController::class, 'absenCepat'])->name('absensi.cepat');

        // Jadwal
        Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
        Route::get('/jadwal/{jadwal}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');
        Route::put('/jadwal/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
        Route::delete('/jadwal/{jadwal}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

        // Jenis Barang
        Route::post('/jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
        Route::put('/jenis-barang/{jenisBarang}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
        Route::delete('/jenis-barang/{jenisBarang}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');

        // Kas
        Route::get('/kas/create', [KasController::class, 'create'])->name('kas.create');
        Route::post('/kas', [KasController::class, 'store'])->name('kas.store');
        Route::get('/kas/{kas}/edit', [KasController::class, 'edit'])->name('kas.edit');
        Route::put('/kas/{kas}', [KasController::class, 'update'])->name('kas.update');
        Route::delete('/kas/{kas}', [KasController::class, 'destroy'])->name('kas.destroy');
    });

    // User Management - Only Superuser
    Route::middleware(['role:superuser'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
