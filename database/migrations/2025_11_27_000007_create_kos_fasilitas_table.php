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
        Schema::create('kos_fasilitas', function (Blueprint $table) {
            $table->unsignedBigInteger('kos_id');
            $table->unsignedBigInteger('fasilitas_id');

            $table->primary(['kos_id', 'fasilitas_id']);
            $table->foreign('kos_id')->references('kos_id')->on('kos')->onDelete('cascade');
            $table->foreign('fasilitas_id')->references('fasilitas_id')->on('fasilitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos_fasilitas');
    }
};
