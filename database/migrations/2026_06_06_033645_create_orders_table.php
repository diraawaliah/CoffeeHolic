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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menyambungkan pesanan dengan ID User (Pembeli)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Menyambungkan pesanan dengan ID Menu (Kopi yang dibeli)
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            
            // Mencatat jumlah beli dan total harga
            $table->integer('quantity')->default(1);
            $table->integer('total_price');
            
            // Mencatat status pesanan (pending, diproses, selesai)
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
