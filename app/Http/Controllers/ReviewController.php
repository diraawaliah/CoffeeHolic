<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        // Simpan ke tabel reviews
        Review::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_campaign' => $request->has('is_campaign') ? true : false 
        ]);
        
        return redirect('/#trending-reviews')->with('success', 'Mantap! Review jujurmu sudah tersimpan. ✨');
    }
}