<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Order; // <--- Tambahkan model Order

class AdminController extends Controller
{
    public function index()
    {
        // 1. Penjaga Pintu: Cek apakah yang login adalah admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        // 2. Tarik semua data menu dari database (Kode aslimu)
        $menus = Menu::latest()->get();

        // 3. Tarik semua data pesanan dari yang paling baru, sekalian bawa data user & menu-nya (Kode baruku)
        $orders = Order::with(['user', 'menu'])->latest()->get();

        // 4. Bawa KEDUANYA ke halaman dashboard
        return view('admin.dashboard', compact('menus', 'orders'));
    }

    // Fungsi untuk mengubah status pesanan (Pending -> Diproses -> Selesai)
    public function updateStatus(Request $request, $id)
    {
        // Penjaga pintu ganda (Pastikan hanya admin yang bisa nge-hit fungsi ini)
        if (Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Mantap! Status pesanan #' . $order->id . ' berhasil diubah menjadi ' . strtoupper($request->status) . '.');
    }
}