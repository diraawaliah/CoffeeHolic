<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'quantity',
        'notes'
    ];

    // Relasi: Keranjang ini terhubung ke tabel Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Relasi: Keranjang ini terhubung ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}