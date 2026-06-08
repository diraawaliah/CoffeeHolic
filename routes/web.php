<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Rute Halaman Utama
Route::get('/', function (Request $request) { 
    // Ambil 4 data saja untuk Top Picks
    $topPicks = \App\Models\Menu::take(4)->get(); 
    
    // Logika kolom search
    $query = $request->input('search');
    
    if ($query) {
        // Kalau ada yang dicari, filter berdasarkan nama kopi ATAU kategorinya
        $allMenus = \App\Models\Menu::where('name', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%")
                    ->get();
    } else {
        // Kalau kolom pencarian kosong, tampilkan semua seperti biasa
        $allMenus = \App\Models\Menu::all(); 
    }
    
    // Tarik review biasa dan campaign secara terpisah (INI TEMPAT YANG BENAR)
    $reviews = \App\Models\Review::with(['user', 'menu'])->where('is_campaign', false)->latest()->take(6)->get();
    $campaignReviews = \App\Models\Review::with(['user', 'menu'])->where('is_campaign', true)->latest()->take(6)->get();
    
    // Lempar semuanya ke halaman welcome, termasuk variabel query-nya
    return view('welcome', compact('topPicks', 'allMenus', 'reviews', 'campaignReviews', 'query'));
});

// Rute Campaign (Bisa diakses tanpa login untuk lihat banner)
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');

// Rute Dashboard
Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute yang butuh Login
Route::middleware('auth')->group(function () {
    // Profile (Sudah dirapikan agar tidak dobel)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('/admin/menus', MenuController::class);
    Route::patch('/admin/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.orders.status');
    
    // Transaksi
    Route::post('/order/{id}', [OrderController::class, 'store'])->name('order.store');
    Route::post('/cart/add/{id}', [CartController::class, 'store'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout.process');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.history');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    // Review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';