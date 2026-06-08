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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // ID pembeli yang punya keranjang ini
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ID kopi yang dimasukkan ke keranjang
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');
            
            // Jumlah pesanan (default 1)
            $table->integer('quantity')->default(1);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
