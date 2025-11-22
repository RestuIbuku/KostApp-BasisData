<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set default jumlah_kamar_total for existing records
        // Assuming each kos has at least 1 room, set to jumlah_kamar_kosong + 1 or minimum 1
        DB::statement('UPDATE kos SET jumlah_kamar_total = GREATEST(jumlah_kamar_kosong + 1, 1) WHERE jumlah_kamar_total = 0 OR jumlah_kamar_total IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to rollback data update
    }
};
