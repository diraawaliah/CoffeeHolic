<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - CoffeeHolic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f9fafb; margin: 0; padding: 0; }
        .cart-container { max-width: 900px; margin: 40px auto; padding: 0 20px; display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; }
        @media (max-width: 768px) { .cart-container { grid-template-columns: 1fr; } }
        .card-aesthetic { background: #fff; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .playfair-title { font-family: 'Playfair Display', serif; color: #1e293b; margin-top: 0; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #f1f5f9; }
        .cart-item:last-child { border-bottom: none; }
        .form-group { display: flex; flex-direction: column; gap: 8px; margin-bottom: 15px; }
        .form-control { padding: 12px; border: 1px solid #e2e8f0; border-radius: 10px; font-family: inherit; }
        .btn-primary { background: #ee4d2d; color: white; border: none; padding: 15px; border-radius: 12px; font-weight: bold; cursor: pointer; width: 100%; transition: 0.3s; font-size: 16px; }
        .btn-primary:hover { background: #d03e20; }
    </style>
</head>
<body>

    <div style="background: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;">
        <a href="/" style="text-decoration: none; color: #64748b; font-weight: bold;"><i class="fas fa-arrow-left"></i> Kembali ke Menu</a>
        <h1 style="margin: 0; font-size: 24px; color: #333;">COFFEE<span style="color: #ee4d2d;">HOLIC</span></h1>
        <div style="width: 100px;"></div> </div>

    <div class="cart-container">
        <div class="card-aesthetic">
            <h2 class="playfair-title"><i class="fas fa-shopping-basket" style="color: #ee4d2d;"></i> Keranjangmu</h2>
            
            @if($cartItems->isEmpty())
                <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                    <i class="fas fa-box-open fa-3x" style="margin-bottom: 15px;"></i>
                    <p>Yah, keranjangmu masih kosong. Yuk pilih kopi dulu!</p>
                    <a href="/" style="color: #ee4d2d; text-decoration: none; font-weight: bold;">Ke Menu Utama</a>
                </div>
            @else
                @foreach($cartItems as $item)
                <div class="cart-item" style="display: flex; flex-direction: column; gap: 12px; padding: 20px 0;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <div style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; background: #fff1f0;">
                                @if($item->menu->image_path)
                                    <img src="{{ asset($item->menu->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="fas fa-coffee" style="color: #ee4d2d; font-size: 24px;"></i></div>
                                @endif
                            </div>
                            <div>
                                <h3 style="margin: 0; font-size: 16px; color: #333;">{{ $item->menu->name }}</h3>
                                <p style="margin: 5px 0 0 0; font-size: 14px; color: #ee4d2d; font-weight: bold;">Rp {{ number_format($item->menu->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 8px;">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" style="background: #f1f5f9; color: #333; border: none; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            </form>

                            <span style="font-weight: 800; font-size: 15px; width: 24px; text-align: center; color: #1e293b;">{{ $item->quantity }}</span>

                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" style="background: #ee4d2d; color: white; border: none; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.2s;" onmouseover="this.style.background='#d03e20'" onmouseout="this.style.background='#ee4d2d'">+</button>
                            </form>

                            <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="margin-left: 10px;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 16px; transition: 0.2s;" onmouseover="this.style.color='#b91c1c'" onmouseout="this.style.color='#ef4444'"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>

                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; gap: 10px; width: 100%; align-items: center; background: #f8fafc; padding: 12px 15px; border-radius: 10px; border: 1px solid #f1f5f9; box-sizing: border-box;">
                        @csrf @method('PATCH')
                        <i class="fas fa-pen" style="color: #94a3b8; font-size: 12px;"></i>
                        <input type="text" name="notes" value="{{ $item->notes }}" placeholder="Ketik preferensimu (Misal: Less sugar, Normal ice, Tambah Boba...)" style="flex-grow: 1; border: none; background: transparent; font-size: 13px; outline: none; font-family: inherit; color: #475569;" onchange="this.form.submit()">
                    </form>

                </div>
                @endforeach
            @endif
        </div>

        <div class="card-aesthetic" style="height: fit-content;">
            <h2 class="playfair-title" id="shippingTitle">Detail Pesanan</h2>

        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 12px; margin-bottom: 20px;">
            <p style="margin: 0; font-size: 12px; color: #166534; font-weight: bold;"><i class="fas fa-store"></i> Lokasi Toko:</p>
            <a href="https://maps.google.com/?q=Gedung+Teknik+Elektro+PNJ+Depok" target="_blank" style="margin: 5px 0 0 0; font-size: 13px; color: #15803d; text-decoration: underline;">
                Gedung Teknik Elektro, PNJ Raya, Depok.
            </a>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
            <div class="form-group">
                <label style="font-size: 13px; font-weight: bold;">Tipe Pesanan</label>
                <select name="order_type" id="orderType" class="form-control" onchange="toggleFields()">
                    <option value="dine-in">Dine-in (Minum di Sini)</option>
                    <option value="takeaway">Takeaway (Bungkus)</option>
                    <option value="pickup">Pickup (Ambil Nanti)</option>
                    <option value="delivery">Delivery (Kirim ke Alamat)</option>
                </select>
            </div>

            <div class="form-group" id="addressContainer" style="display: none;">
                <label style="font-size: 13px; font-weight: bold;">Alamat Lengkap Pengiriman</label>
                <textarea name="address" class="form-control" placeholder="Jl. Nama Jalan No. 123, Depok..." rows="2"></textarea>
            </div>

            <div class="form-group">
                <label style="font-size: 13px; font-weight: bold;">Metode Pembayaran</label>
                <select name="payment_method" class="form-control">
                    <option value="qris">QRIS / E-Wallet</option>
                    <option value="cash">Cash / Bayar di Tempat</option>
                </select>
            </div>
            
            <div class="form-group">
                <label style="font-size: 13px; font-weight: bold;">Catatan Tambahan</label>
                <input type="text" name="notes" class="form-control" placeholder="Misal: Less sugar, extra es...">
            </div>

            <div style="border-top: 2px dashed #e2e8f0; margin: 20px 0;"></div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <span style="font-weight: bold; color: #64748b;">Total Bayar</span>
                <span style="font-size: 22px; font-weight: 900; color: #ee4d2d;">Rp {{ number_format($totalPrice ?? 0, 0, ',', '.') }}</span>
            </div>

            <button type="submit" class="btn-primary">Buat Pesanan Sekarang <i class="fas fa-check-circle"></i></button>
        </form>
        </div>
    </div>

    <script>
    function toggleFields() {
        const type = document.getElementById('orderType').value;
        const addrContainer = document.getElementById('addressContainer');
        const shippingTitle = document.getElementById('shippingTitle'); // Asumsi kamu kasih ID ini ke h2 Detail Pesanan

        if (type === 'delivery') {
            addrContainer.style.display = 'flex';
            if(shippingTitle) shippingTitle.innerText = 'Detail Pengiriman';
        } else {
            addrContainer.style.display = 'none';
            if(shippingTitle) shippingTitle.innerText = 'Detail Pesanan';
        }
    }
    </script>
</body>
</html>