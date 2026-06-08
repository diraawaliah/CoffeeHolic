<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - CoffeeHolic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { background: #f9fafb; font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; }
        .badge-pending { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .badge-diproses { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-selesai { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-batal { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    </style>
</head>
<body>

    <div style="background: white; padding: 20px 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 10;">
        <a href="/" style="text-decoration: none; color: #64748b; font-weight: bold; transition: 0.3s;" onmouseover="this.style.color='#ee4d2d'" onmouseout="this.style.color='#64748b'">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Menu
        </a>
        <h1 style="margin: 0; font-family: 'Playfair Display', serif; font-size: 24px; color: #333;">COFFEE<span style="color: #ee4d2d;">HOLIC</span></h1>
        <div style="width: 100px;"></div>
    </div>

    <div style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 30px;">
            <i class="fas fa-receipt" style="font-size: 24px; color: #ee4d2d;"></i>
            <h2 style="font-family: 'Playfair Display', serif; margin: 0; font-size: 28px; color: #1e293b;">Riwayat Pesananku</h2>
        </div>

        @forelse($orders as $order)
        <div style="background: white; border-radius: 16px; padding: 20px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; border: 1px solid #f1f5f9; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="width: 70px; height: 70px; background: #fff1f0; border-radius: 12px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                    @if($order->menu && $order->menu->image_path)
                        <img src="{{ asset($order->menu->image_path) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-coffee" style="color: #ee4d2d; font-size: 28px;"></i>
                    @endif
                </div>
                <div>
                    <p style="margin: 0 0 5px 0; font-size: 12px; color: #94a3b8; font-weight: bold;">
                        <span style="color: #cbd5e1;">#{{ $order->id }}</span> • {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                    <h3 style="margin: 0 0 5px 0; font-size: 18px; color: #1e293b;">
                        {{ $order->menu ? $order->menu->name : 'Menu Terhapus' }} 
                        <span style="color: #ee4d2d; font-size: 14px;">(x{{ $order->quantity }})</span>
                    </h3>
                    <p style="margin: 0; font-size: 15px; font-weight: 800; color: #16a34a;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div style="text-align: right;">
                @if($order->status == 'pending') 
                    <span class="badge badge-pending"><i class="fas fa-hourglass-half mr-1"></i> Menunggu Konfirmasi</span>
                @elseif($order->status == 'diproses') 
                    <span class="badge badge-diproses"><i class="fas fa-fire mr-1"></i> Sedang Diracik</span>
                @elseif($order->status == 'selesai') 
                    <span class="badge badge-selesai"><i class="fas fa-check-circle mr-1"></i> Selesai</span>
                @elseif($order->status == 'batal') 
                    <span class="badge badge-batal"><i class="fas fa-times-circle mr-1"></i> Dibatalkan</span>
                @endif
                
                <div style="margin-top: 12px; font-size: 11px; color: #64748b; font-weight: bold; text-transform: uppercase; background: #f8fafc; padding: 4px 10px; border-radius: 8px; display: inline-block;">
                    <i class="fas fa-motorcycle mr-1"></i> {{ $order->order_type }}
                </div>
            </div>

        </div>
        @empty
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px dashed #cbd5e1;">
            <i class="fas fa-box-open fa-4x" style="color: #e2e8f0; margin-bottom: 20px;"></i>
            <h3 style="margin: 0 0 10px 0; color: #475569; font-family: 'Playfair Display', serif;">Belum ada pesanan</h3>
            <p style="margin: 0; color: #94a3b8; font-size: 14px;">Sepertinya kamu belum pernah memesan kopi. Yuk order sekarang!</p>
        </div>
        @endforelse

    </div>
</body>
</html>