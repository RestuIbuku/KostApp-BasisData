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
        Schema::create('booking', function (Blueprint $table) {
            $table->id('booking_id');
            $table->unsignedBigInteger('pencari_id');
            $table->unsignedBigInteger('kamar_id');
            $table->date('tgl_mulai_sewa');
            $table->date('tgl_selesai_sewa');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_booking', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('pencari_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('kamar_id')->references('kamar_id')->on('kamar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
