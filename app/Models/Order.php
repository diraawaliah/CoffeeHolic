<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'menu_id', 'quantity', 'total_price', 'status', 
        'order_type', 'pickup_time', 'notes', 'payment_method'
    ];

    // Kabel Relasi ke Pembeli (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kabel Relasi ke Produk (Menu)
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}