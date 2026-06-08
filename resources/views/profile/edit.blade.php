<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'], serif: ['Playfair Display', 'serif'] }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-orange-200">
    
    <nav class="bg-white shadow-sm py-4 px-6 sticky top-0 z-50 flex justify-between items-center border-b border-gray-100">
        <a href="/" class="text-gray-500 font-bold hover:text-orange-600 transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Menu
        </a>
        <h1 class="font-serif text-2xl font-bold tracking-wider text-gray-800">COFFEE<span class="text-orange-600">HOLIC</span></h1>
        <div class="w-24"></div>
    </nav>

    <main class="max-w-4xl mx-auto py-12 px-4 md:px-8">
        <div class="mb-10 text-center">
            <h2 class="font-serif text-3xl font-bold text-gray-900 mb-2">Pengaturan Akun</h2>
            <p class="text-gray-500">Kelola identitas dan keamanan akun CoffeeHolic kamu di sini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xl"><i class="fas fa-user-edit"></i></div>
                    <h3 class="text-xl font-bold text-gray-800">Informasi Profil</h3>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-orange-600 text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">
                        Simpan Perubahan
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p class="text-sm text-green-600 font-bold text-center mt-3"><i class="fas fa-check-circle"></i> Profil berhasil diperbarui!</p>
                    @endif
                </form>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl"><i class="fas fa-lock"></i></div>
                    <h3 class="text-xl font-bold text-gray-800">Ubah Password</h3>
                </div>

                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full p-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition" required>
                        @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full p-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition" required>
                        @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full p-3 rounded-xl border border-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition" required>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 hover:bg-red-600 text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">
                        Update Password
                    </button>

                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-green-600 font-bold text-center mt-3"><i class="fas fa-check-circle"></i> Password berhasil diubah!</p>
                    @endif
                </form>
            </div>

        </div>
    </main>

</body>
</html>