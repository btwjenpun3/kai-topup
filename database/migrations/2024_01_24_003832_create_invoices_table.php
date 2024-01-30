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
            $table->string('nomor_invoice')->unique();
            $table->string('user_id');
            $table->string('server_id')->nullable();
            $table->string('customer');  
            $table->string('phone');          
            $table->string('xendit_invoice_id');
            $table->foreignId('game_id')->constrained();
            $table->foreignId('harga_id')->constrained();
            $table->foreignId('payment_id')->constrained();   
            $table->foreignId('digiflazz_id')->nullable()->constrained();  
            $table->foreignId('xendit_e_wallet_id')->nullable()->constrained(); 
            $table->foreignId('xendit_qr_id')->nullable()->constrained();
            $table->foreignId('xendit_va_id')->nullable()->constrained();
            $table->foreignId('xendit_outlet_id')->nullable()->constrained();
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
