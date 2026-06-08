<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambah kolom tipe pesanan (dine-in, takeaway, delivery)
            $table->string('order_type')->default('dine-in')->after('quantity');
            
            // Menambah kolom waktu ambil (boleh kosong/nullable kalau tipe pesanannya dine-in/delivery)
            $table->dateTime('pickup_time')->nullable()->after('order_type');
            
            // Menambah kolom catatan tambahan dari pembeli (opsional)
            $table->text('notes')->nullable()->after('pickup_time');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Agar bisa di-rollback (dihapus) jika terjadi kesalahan
            $table->dropColumn(['order_type', 'pickup_time', 'notes']);
        });
    }
};