<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">
    
    <nav class="bg-white shadow-sm py-4 px-6 sticky top-0 z-50 flex justify-between items-center border-b border-gray-100">
        <a href="/" class="text-gray-500 font-bold hover:text-orange-600 transition flex items-center gap-2">
            Kembali ke Menu
        </a>
        <h1 class="font-serif text-2xl font-bold tracking-wider text-gray-800">COFFEE<span class="text-orange-600">HOLIC</span></h1>
        <div class="w-24"></div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4 md:px-8">
        <div class="mb-8 border-b border-gray-200 pb-4">
            <h2 class="font-serif text-3xl font-bold text-gray-900">Riwayat Pesanan Saya</h2>
            <p class="text-gray-500 mt-1">Daftar semua kopi dan kebahagiaan yang pernah kamu pesan.</p>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center">
                <p class="text-gray-500 text-lg mb-4">Kamu belum pernah memesan apapun.</p>
                <a href="/" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-full transition">Mulai Pesan Sekarang</a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <p class="text-sm text-gray-500 font-bold mb-1">Order #{{ $order->id }} • {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 mt-1">Status Pembayaran: <span class="font-bold text-orange-500">{{ $order->payment_status ?? 'Pending' }}</span></p>
                    </div>
                    <div>
                        <span class="px-4 py-2 rounded-full text-sm font-bold 
                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->status ?? 'Diproses') }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>