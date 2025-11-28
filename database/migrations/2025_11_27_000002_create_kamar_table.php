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
        Schema::create('kamar', function (Blueprint $table) {
            $table->id('kamar_id');
            $table->unsignedBigInteger('kos_id');
            $table->string('nama_kamar', 100);
            $table->decimal('harga_per_malam', 12, 2);
            $table->enum('status_ketersediaan', ['tersedia', 'penuh'])->default('tersedia');
            $table->string('ukuran_kamar', 50)->nullable();

            $table->foreign('kos_id')->references('kos_id')->on('kos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
