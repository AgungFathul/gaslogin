<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //membuat tabel tournaments otomatis
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('url')->unique();
            $table->date('jadwal_mulai');
            $table->date('jadwal_selesai');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['Online', 'Offline']);
            $table->string('alamat')->nullable();
            $table->text('hadiah')->nullable();
            $table->text('rules')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
