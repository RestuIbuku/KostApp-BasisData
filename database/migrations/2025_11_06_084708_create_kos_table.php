<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kos', function (Blueprint $table) {
            $table->id('kos_id');
            $table->foreignId('pemilik_id')->constrained('users', 'user_id');
            $table->string('nama_kos', 150);
            $table->text('alamat');
            $table->text('deskripsi');
            $table->enum('tipe_kos', ['putra', 'putri', 'campur']);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kos');
    }
};
