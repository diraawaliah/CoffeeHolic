<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-[#fff1f0] flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white p-8 md:p-10 rounded-3xl shadow-xl border border-orange-100">
        
        <div class="text-center mb-8">
            <h1 class="font-serif text-4xl font-bold tracking-wider text-gray-800">COFFEE<span class="text-[#FF7A45]">HOLIC</span></h1>
            <p class="text-gray-500 text-sm mt-2">Welcome back! Grab your coffee and sign in.</p>
        </div>

        <x-auth-session-status class="mb-4 text-red-600 text-sm font-bold text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-5">
                <label class="block font-bold text-sm text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="mb-6">
                <label class="block font-bold text-sm text-gray-700 mb-2">Password</label>
                <input type="password" name="password" class="w-full p-3.5 rounded-xl border border-gray-300 focus:border-[#FF7A45] focus:ring-2 focus:ring-orange-200 outline-none transition" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-[#FF7A45] transition">
                    <input type="checkbox" name="remember" class="mr-2 text-[#FF7A45] focus:ring-[#FF7A45] border-gray-300 rounded">
                    Remember me
                </label>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-gray-600 hover:text-[#FF7A45] transition">Forgot password?</a>
                @endif
            </div>

            <button type="submit" class="w-full bg-[#FF7A45] hover:bg-[#E0602E] text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-orange-500/30 text-lg">
                Log In
            </button>
            
            @if (Route::has('register'))
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-[#FF7A45] font-bold hover:underline">Sign up here</a></p>
            </div>
            @endif
        </form>
        
    </div>
</body>
</html>