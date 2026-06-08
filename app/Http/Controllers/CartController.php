<?php

namespace App\Http\Controllers; // Harus ada!

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Pastikan ini ditulis 'public function index()'
    public function index() 
    {
        $cartItems = Cart::with('menu')->where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum(function($cart) {
            return $cart->menu->price * $cart->quantity;
        });

        return view('cart', compact('cartItems', 'totalPrice'));
    }
    
    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cart->delete();
        return redirect()->back()->with('success', 'Menu dihapus dari keranjang.');
    }
    
    public function store($id)
    {
        $menu = Menu::findOrFail($id);

        // Cek apakah kopi ini sudah ada di keranjang user
        $cart = Cart::where('user_id', Auth::id())->where('menu_id', $id)->first();

        if ($cart) {
            // Kalau sudah ada, tambahkan jumlahnya saja (Quantity +1)
            $cart->increment('quantity');
        } else {
            // Kalau belum ada, buat item baru di keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'menu_id' => $menu->id,
                'quantity' => 1
            ]);
        }

        // KEMBALIKAN PESAN SUKSES KE SINI!
        return redirect()->back()->with('success', $menu->name . ' berhasil masuk keranjang! 🛒');
    } // <--- KURUNG KURAWAL INI YANG TADI HILANG!

    // Fungsi untuk Update Kuantitas dan Catatan Item Keranjang
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);

        // Jika tombol Plus / Minus diklik
        if ($request->has('action')) {
            if ($request->action == 'increase') {
                $cart->increment('quantity');
            } elseif ($request->action == 'decrease' && $cart->quantity > 1) {
                $cart->decrement('quantity');
            }
        }

        // Jika user mengetik catatan (less sugar, dll)
        if ($request->has('notes')) {
            $cart->update(['notes' => $request->notes]);
        }

        // Pantulkan kembali tanpa pesan agar tidak berisik saat user klik plus/minus berkali-kali
        return redirect()->back();
    }
}