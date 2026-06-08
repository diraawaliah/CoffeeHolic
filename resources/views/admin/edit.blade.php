<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-amber-800 text-white p-4 flex justify-between items-center shadow-md">
        <h1 class="text-xl font-bold tracking-wider">COFFEEHOLIC ADMIN</h1>
        <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-200 transition">Kembali ke Dashboard</a>
    </nav>

    <div class="p-8 max-w-2xl mx-auto mt-6">
        <div class="bg-white p-6 rounded-lg shadow-xl">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Data Menu</h2>
            
            <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                    <input type="text" name="name" value="{{ $menu->name }}" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                    <select name="category" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                        <option value="Coffee" {{ $menu->category == 'Coffee' ? 'selected' : '' }}>Coffee</option>
                        <option value="Non-Coffee" {{ $menu->category == 'Non-Coffee' ? 'selected' : '' }}>Non-Coffee</option>
                        <option value="Dessert" {{ $menu->category == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ $menu->price }}" class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (Biarkan kosong jika tidak ingin ganti)</label>
                    @if($menu->image_path)
                        <div class="mb-2">
                            <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                            <img src="{{ asset($menu->image_path) }}" class="w-20 h-20 object-cover rounded shadow">
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*" class="border rounded w-full py-2 px-3">
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-400 hover:bg-gray-500 text-white py-2 px-4 rounded font-medium">Batal</a>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded font-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>