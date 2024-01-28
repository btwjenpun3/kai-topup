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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained();
            $table->foreignId('harga_id')->constrained();
            $table->foreignId('payment_id')->constrained();
            $table->string('nomor_invoice')->unique();
            $table->string('user_id')->nullable();
            $table->string('server_id')->nullable();
            $table->string('xendit_invoice_id');            
            $table->string('xendit_invoice_url')->nullable();
            $table->string('xendit_qr_string')->nullable();
            $table->string('xendit_va_name')->nullable();
            $table->string('xendit_va_number')->nullable();
            $table->string('xendit_va_payment_id')->nullable();
            $table->integer('total');
            $table->string('status');
            $table->string('webhook_id')->nullable()->unique();
            $table->string('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
