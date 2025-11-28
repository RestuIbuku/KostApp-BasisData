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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->unsignedBigInteger('booking_id')->unique();
            $table->decimal('jumlah', 12, 2);
            $table->string('metode_pembayaran', 50);
            $table->enum('status_pembayaran', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamp('tgl_pembayaran')->nullable();

            $table->foreign('booking_id')->references('booking_id')->on('booking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
