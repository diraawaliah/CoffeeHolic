<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#fff1f0] flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-orange-100 my-8">
        
        <div class="text-center mb-8">
            <h1 class="font-serif text-4xl font-bold tracking-wider text-gray-800">COFFEE<span class="text-[#FF7A45]">HOLIC</span></h1>
            <p class="text-gray-500 text-sm mt-2">Join the club! Buat akun barumu di sini.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            <div class="mb-5">
                <label class="block font-bold text-sm text-gray-700 mb-2">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required autofocus>
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-5">
                <label class="block font-bold text-sm text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-5">
                <label class="block font-bold text-sm text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-8">
                <label class="block font-bold text-sm text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs" />
            </div>

            <button type="submit" class="w-full bg-[#FF7A45] hover:bg-[#E0602E] text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-orange-500/30 text-lg">
                Sign Up
            </button>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">Already registered? <a href="{{ route('login') }}" class="text-[#FF7A45] font-bold hover:underline">Log in here</a></p>
            </div>
        </form>
        
    </div>
</body>
</html>