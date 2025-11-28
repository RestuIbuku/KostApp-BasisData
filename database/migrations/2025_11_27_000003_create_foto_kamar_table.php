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
        Schema::create('foto_kamar', function (Blueprint $table) {
            $table->id('foto_id');
            $table->unsignedBigInteger('kamar_id');
            $table->string('url_foto');
            $table->string('deskripsi_foto', 255)->nullable();

            $table->foreign('kamar_id')->references('kamar_id')->on('kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_kamar');
    }
};
