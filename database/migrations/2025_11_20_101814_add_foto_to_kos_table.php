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
        Schema::table('kos', function (Blueprint $table) {
            // Tambahkan kolom 'foto' setelah kolom 'deskripsi'
            // nullable() artinya kolom ini boleh kosong (tidak wajib diisi)
            $table->string('foto')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kos', function (Blueprint $table) {
            // Hapus kolom 'foto' jika migration di-rollback
            $table->dropColumn('foto');
        });
    }
};