<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Fungsi menangkap Order Direct (Sudah Jarang Dipakai)
    public function store(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        Order::create([
            'user_id' => Auth::id(),
            'menu_id' => $menu->id,
            'quantity' => 1,
            'total_price' => $menu->price,
            'status' => 'pending',
            'order_type' => $request->order_type,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method ?? 'qris',
        ]);

        return redirect()->back()->with('success', 'Menu ' . $menu->name . ' berhasil dipesan langsung!');
    }

    // =========================================================================
    // FUNGSI UTAMA: CHECKOUT DARI KERANJANG (MEMINDAHKAN CARTS KE ORDERS)
    // =========================================================================
    public function checkout(Request $request)
    {
        // 1. Ambil semua isi keranjang user yang login beserta data menunya
        $carts = Cart::with('menu')->where('user_id', Auth::id())->get();

        // Jaga-jaga jika keranjang kosong
        if ($carts->isEmpty()) {
            return redirect('/cart')->withErrors(['Waduh, keranjangmu kosong, jir! Isiin kopi dulu dong.']);
        }

        // Jaga-jaga jika ada user nakal yang bypass form validation tipe pesanan
        if (!$request->has('order_type')) {
             return redirect('/cart')->withErrors(['Pilih tipe pesanan dulu (Delivery/Pickup/Dine-in).']);
        }

        // 2. Gabungkan Catatan Global dengan Alamat jika Delivery
        $finalNotes = $request->notes;
        if ($request->order_type == 'delivery' && $request->has('address')) {
            $finalNotes = " [Alamat Pengiriman: " . $request->address . "] | " . $request->notes;
        }

        // 3. Pindahkan data satu per satu (Iterasi) dari Keranjang ke Order
        foreach ($carts as $cart) {
            Order::create([
                'user_id' => Auth::id(),
                'menu_id' => $cart->menu_id,
                'quantity' => $cart->quantity, // Ini akan menangkap quantity '2' dengan benar!
                'total_price' => $cart->menu->price * $cart->quantity,
                'order_type' => $request->order_type,
                'notes' => $finalNotes,
                'payment_method' => $request->payment_method ?? 'qris',
                'status' => 'pending' // Default status pesanan baru
            ]);
        }

        // 4. Kosongkan Keranjang setelah berhasil checkout
        Cart::where('user_id', Auth::id())->delete();

        // Pantulkan kembali ke halaman utama dengan notifikasi SweetAlert
        return redirect('/')->with('success', 'Yeay! Pesanan berhasil dibuat. Kopi favoritmu akan segera diproses! ☕✨');
    }
}