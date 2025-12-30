<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengangkutan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('wilayah'); // RT/RW
            $table->decimal('volume', 10, 2); // dalam m3 atau kg
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawan')->nullOnDelete();
            $table->string('nama_petugas')->nullable(); // backup jika karyawan tidak terdaftar
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengangkutan');
    }
};
