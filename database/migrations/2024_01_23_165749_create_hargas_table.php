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
        Schema::create('hargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained();
            $table->string('nama_produk');            
            $table->string('seller_name');
            $table->string('kode_produk');
            $table->string('deskripsi');
            $table->string('gambar');
            $table->integer('modal');
            $table->integer('harga_jual');
            $table->integer('profit');
            $table->string('start_cut_off');
            $table->string('end_cut_off');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hargas');
    }
};
