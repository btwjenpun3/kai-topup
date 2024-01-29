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
        Schema::create('digiflazzs', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->nullable();
            $table->integer('saldo_terakhir');
            $table->integer('saldo_terpotong');
            $table->string('message');
            $table->string('seller_telegram');
            $table->string('seller_whatsapp');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digiflazzs');
    }
};
