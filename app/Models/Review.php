<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'menu_id', 'rating', 'comment', 'is_campaign'
    ];

    // Relasi ke User (Siapa yang nulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Menu (Kopi apa yang di-review)
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}