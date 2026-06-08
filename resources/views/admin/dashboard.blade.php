<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-amber-800 text-white p-4 flex justify-between items-center shadow-md">
        <h1 class="text-xl font-bold tracking-wider">COFFEEHOLIC ADMIN</h1>
        <a href="/" class="hover:text-amber-200 transition"><i class="fas fa-store mr-2"></i>Lihat Web Utama</a>
    </nav>

    <div class="p-8 max-w-7xl mx-auto mt-6">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex border-b border-gray-300 mb-6">
            <button onclick="switchTab('orders')" id="tabBtn-orders" class="py-2 px-6 border-b-2 border-amber-800 text-amber-800 font-bold focus:outline-none transition-all">
                <i class="fas fa-clipboard-list mr-2"></i>Pesanan Masuk
            </button>
            <button onclick="switchTab('menus')" id="tabBtn-menus" class="py-2 px-6 border-b-2 border-transparent text-gray-500 hover:text-amber-800 font-semibold focus:outline-none transition-all">
                <i class="fas fa-coffee mr-2"></i>Manajemen Menu
            </button>
        </div>

        <div id="content-orders" class="block">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Daftar Pesanan Masuk</h2>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden border-t-4 border-amber-800 overflow-x-auto">
                <table class="min-w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-800">ID</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Pelanggan</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Detail Kopi</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Tipe / Waktu</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Catatan</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Total Harga</th>
                            <th class="px-6 py-4 font-semibold text-gray-800 text-center">Status & Aksi</th> </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-amber-600">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $order->user ? $order->user->name : 'User Terhapus' }}</div>
                                <div class="text-xs text-gray-500 mt-1 uppercase">{{ $order->payment_method }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">{{ $order->menu ? $order->menu->name : 'Menu Terhapus' }}</span> 
                                <span class="text-amber-600 font-bold ml-1">(x{{ $order->quantity }})</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($order->order_type == 'dine-in') <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded-full uppercase">Dine-in</span>
                                @elseif($order->order_type == 'pickup') <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded-full uppercase">Pickup</span>
                                @elseif($order->order_type == 'delivery') <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full uppercase">Delivery</span>
                                @else <span class="bg-pink-100 text-pink-800 text-xs font-bold px-2 py-1 rounded-full uppercase">Takeaway</span>
                                @endif
                                
                                @if($order->pickup_time)
                                    <div class="text-xs text-gray-500 mt-2"><i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($order->pickup_time)->format('d M, H:i') }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                @if($order->notes)
                                    <div class="bg-gray-100 p-2 rounded text-xs border border-gray-200">
                                        {{ $order->notes }}
                                    </div>
                                @else
                                    <span class="text-gray-400 italic text-xs">- Tidak ada catatan -</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded text-xs p-2 font-bold cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-500
                                        {{ $order->status == 'pending' ? 'bg-gray-100 text-gray-600' : '' }}
                                        {{ $order->status == 'diproses' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $order->status == 'selesai' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $order->status == 'batal' ? 'bg-red-100 text-red-700' : '' }}
                                    ">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ PENDING</option>
                                        <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>🔥 DIPROSES</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>✅ SELESAI</option>
                                        <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>❌ BATAL</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan yang masuk hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="content-menus" class="hidden">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Manajemen Katalog Menu</h2>
                <button onclick="toggleModal('modalTambah')" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    + Tambah Menu Baru
                </button>
            </div>

            <div class="bg-white rounded-lg shadow-sm overflow-hidden border-t-4 border-amber-800">
                <table class="min-w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-4 font-semibold text-gray-800">Gambar</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Nama Menu</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Kategori</th>
                            <th class="px-6 py-4 font-semibold text-gray-800">Harga</th>
                            <th class="px-6 py-4 font-semibold text-gray-800 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($menus as $menu)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                @if($menu->image_path)
                                    <img src="{{ asset($menu->image_path) }}" alt="{{ $menu->name }}" class="w-16 h-16 object-cover rounded shadow-sm">
                                @else
                                    <span class="text-gray-400 italic">Tanpa Gambar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $menu->name }}</td>
                            <td class="px-6 py-4">{{ $menu->category }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center space-x-3">
                                <a href="{{ route('menus.edit', $menu->id) }}" class="text-blue-500 hover:text-blue-700 font-medium inline-block mr-2">Edit</a>
                                <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin nih komandan mau menghapus menu {{ addslashes($menu->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                @if($menus->isEmpty())
                    <div class="p-6 text-center text-gray-500">
                        Belum ada data menu. Silakan tambahkan menu baru melalui tombol di atas.
                    </div>
                @endif
            </div>
        </div>

    </div>

    <div id="modalTambah" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center overflow-y-auto h-full w-full z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md mx-4">
            <h3 class="text-xl font-bold mb-4 border-b pb-2">Form Tambah Kopi</h3>
            
            <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                    <input type="text" name="name" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="category" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                        <option value="Coffee">Coffee</option>
                        <option value="Non-Coffee">Non-Coffee</option>
                        <option value="Dessert">Dessert</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Gambar (Opsional)</label>
                    <input type="file" name="image" accept="image/*" class="border rounded w-full py-2 px-3">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="toggleModal('modalTambah')" class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded transition">Batal</button>
                    <button type="submit" class="bg-amber-800 hover:bg-amber-900 text-white py-2 px-4 rounded transition">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script Modal Bawaanmu
        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            modal.classList.toggle("hidden");
        }

        // Script Baru untuk Ganti Tab
        function switchTab(tabName) {
            // Sembunyikan semua konten
            document.getElementById('content-orders').classList.add('hidden');
            document.getElementById('content-orders').classList.remove('block');
            document.getElementById('content-menus').classList.add('hidden');
            document.getElementById('content-menus').classList.remove('block');

            // Reset gaya tombol
            const btnOrders = document.getElementById('tabBtn-orders');
            const btnMenus = document.getElementById('tabBtn-menus');
            
            btnOrders.className = "py-2 px-6 border-b-2 border-transparent text-gray-500 hover:text-amber-800 font-semibold focus:outline-none transition-all";
            btnMenus.className = "py-2 px-6 border-b-2 border-transparent text-gray-500 hover:text-amber-800 font-semibold focus:outline-none transition-all";

            // Tampilkan konten yang dipilih dan ubah gaya tombolnya
            if(tabName === 'orders') {
                document.getElementById('content-orders').classList.remove('hidden');
                document.getElementById('content-orders').classList.add('block');
                btnOrders.className = "py-2 px-6 border-b-2 border-amber-800 text-amber-800 font-bold focus:outline-none transition-all";
            } else {
                document.getElementById('content-menus').classList.remove('hidden');
                document.getElementById('content-menus').classList.add('block');
                btnMenus.className = "py-2 px-6 border-b-2 border-amber-800 text-amber-800 font-bold focus:outline-none transition-all";
            }
        }
    </script>
</body>
</html>