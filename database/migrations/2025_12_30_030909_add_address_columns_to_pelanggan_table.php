<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('rt')->nullable()->after('alamat');
            $table->string('rw')->nullable()->after('rt');
            $table->string('dusun')->nullable()->after('rw');
            $table->string('desa')->nullable()->after('dusun');
            $table->string('kecamatan')->nullable()->after('desa');
            $table->string('kab_kota')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'dusun', 'desa', 'kecamatan', 'kab_kota']);
        });
    }
};
