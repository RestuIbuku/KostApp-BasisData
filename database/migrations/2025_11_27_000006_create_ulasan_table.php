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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('ulasan_id');
            $table->unsignedBigInteger('kos_id');
            $table->unsignedBigInteger('pencari_id');
            $table->unsignedBigInteger('booking_id')->nullable();
            $table->integer('rating');
            $table->text('komentar')->nullable();
            $table->timestamp('tgl_ulasan')->useCurrent();

            $table->foreign('kos_id')->references('kos_id')->on('kos')->onDelete('cascade');
            $table->foreign('pencari_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
