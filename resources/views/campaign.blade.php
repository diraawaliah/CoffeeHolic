<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goguma Campaign - CoffeeHolic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-rose-50 text-gray-800 antialiased selection:bg-rose-300 selection:text-rose-900">
    
    <nav class="bg-white/80 backdrop-blur-md shadow-sm py-4 px-6 fixed w-full top-0 z-50 flex justify-between items-center border-b border-rose-100">
        <a href="/" class="text-rose-600 font-bold hover:text-rose-800 transition flex items-center gap-2 text-sm md:text-base">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="font-serif text-2xl font-bold text-gray-800 tracking-wider">COFFEE<span class="text-rose-600">HOLIC</span></h1>
        <div class="w-16 md:w-24"></div> </nav>

    <main class="pt-28 pb-16 px-4 md:px-8 max-w-6xl mx-auto">
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-rose-50">
            
            <div class="md:w-1/2 relative group overflow-hidden">
                <img src="{{ asset('img/Goguma.jpg') }}" alt="Goguma Point Coffee" class="w-full h-full object-cover object-center min-h-[400px] transition duration-700 group-hover:scale-105">
                <div class="absolute top-6 left-6 bg-white/95 backdrop-blur px-5 py-2 rounded-full font-bold text-rose-600 shadow-xl flex items-center gap-2 text-sm border border-rose-100">
                    <i class="fas fa-fire-alt animate-pulse"></i> Trending Campaign
                </div>
            </div>

            <div class="md:w-1/2 p-8 md:p-14 flex flex-col justify-center bg-gradient-to-br from-white to-rose-50/50">
                <span class="text-rose-500 font-extrabold tracking-[0.2em] text-xs uppercase mb-3">Exclusive Review Challenge</span>
                <h2 class="font-serif text-4xl md:text-5xl font-bold text-gray-900 mb-5 leading-tight">
                    Goguma Series <br><span class="text-rose-600">Point Coffee</span>
                </h2>
                
                <div class="flex flex-wrap items-center gap-4 mb-8 text-sm text-gray-600 font-semibold">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-rose-100 flex items-center gap-2">
                        <i class="far fa-calendar-alt text-rose-500 text-lg"></i> 4 Apr - 14 Apr 2026
                    </div>
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-rose-100 flex items-center gap-2">
                        <i class="fas fa-users text-rose-500 text-lg"></i> Kuota: 20 Reviewer Terpilih
                    </div>
                </div>

                <p class="text-gray-600 mb-8 leading-relaxed text-md">
                    Siapa yang bisa nolak perpaduan unik kopi premium dengan rasa manis gurih khas ubi Goguma? Kami mencari 20 ulasan paling jujur dan kreatif untuk membantu komunitas menemukan rasa favorit mereka di bulan ini!
                </p>

                <div class="bg-gradient-to-r from-rose-100 to-pink-100 border-l-4 border-rose-500 p-5 mb-10 rounded-r-xl shadow-inner">
                    <h4 class="font-bold text-rose-900 mb-2 flex items-center gap-2 text-lg">
                        <i class="fas fa-gift text-rose-600"></i> Reward Challenge
                    </h4>
                    <p class="text-sm text-rose-800 leading-relaxed">
                        Tulis ulasan paling menarik dan menangkan <strong>E-Voucher Point Coffee senilai Rp 50.000</strong> untuk 20 orang pemenang beruntung!
                    </p>
                </div>

               <button type="button" onclick="event.preventDefault(); document.getElementById('campaignReviewModal').style.display='flex';" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-4 px-8 rounded-full text-center transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl shadow-rose-600/30 flex items-center justify-center gap-3 text-lg w-full md:w-auto">
                    <i class="fas fa-pen-nib"></i> Tulis Review Sekarang
                </button>
                </a>
            </div>
        </div>

        <div class="mt-24">
            <div class="text-center mb-14">
                <h3 class="font-serif text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Ikutan Challenge</h3>
                <div class="h-1 w-20 bg-rose-500 mx-auto rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-3xl shadow-lg text-center border-t-4 border-rose-300 relative hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center font-bold text-2xl absolute -top-7 left-1/2 transform -translate-x-1/2 ring-8 ring-rose-50 shadow-md">1</div>
                    <i class="fas fa-coffee text-5xl text-rose-300 mb-6 mt-6"></i>
                    <h4 class="font-bold text-xl mb-3 text-gray-800">Beli Menunya</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Pesan menu Goguma Series Point Coffee favoritmu via CoffeeHolic atau datang langsung ke outlet terdekat.</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-lg text-center border-t-4 border-rose-500 relative hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-rose-500 text-white rounded-full flex items-center justify-center font-bold text-2xl absolute -top-7 left-1/2 transform -translate-x-1/2 ring-8 ring-rose-50 shadow-md">2</div>
                    <i class="fas fa-camera-retro text-5xl text-rose-500 mb-6 mt-6"></i>
                    <h4 class="font-bold text-xl mb-3 text-gray-800">Rasakan & Abadikan</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Nikmati sensasi rasa uniknya, perhatikan aromanya, dan siapkan kalimat terbaik untuk mendeskripsikannya.</p>
                </div>
                
                <div class="bg-white p-8 rounded-3xl shadow-lg text-center border-t-4 border-rose-700 relative hover:-translate-y-2 transition duration-300">
                    <div class="w-14 h-14 bg-rose-700 text-white rounded-full flex items-center justify-center font-bold text-2xl absolute -top-7 left-1/2 transform -translate-x-1/2 ring-8 ring-rose-50 shadow-md">3</div>
                    <i class="fas fa-star text-5xl text-rose-700 mb-6 mt-6"></i>
                    <h4 class="font-bold text-xl mb-3 text-gray-800">Tulis Ulasan Jujur</h4>
                    <p class="text-gray-500 text-sm leading-relaxed">Kembali ke CoffeeHolic, berikan rating bintang dan bagikan review paling menarik versimu ke komunitas!</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white text-center py-8 text-sm text-gray-500 mt-10 border-t border-rose-100">
        <p>&copy; 2026 CoffeeHolic x Point Coffee Campaign.</p>
    </footer>

    <div id="campaignReviewModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[10000] hidden justify-center items-center">
        <div class="bg-white w-[90%] max-w-[450px] p-8 rounded-2xl relative shadow-2xl">
            <button onclick="document.getElementById('campaignReviewModal').style.display='none'" class="absolute top-4 right-4 bg-gray-100 hover:bg-gray-200 text-gray-500 w-8 h-8 rounded-full flex items-center justify-center transition">&times;</button>
            
            <div class="text-center mb-6">
                <h2 class="font-serif text-2xl font-bold text-pink-700 mb-1">Review Campaign</h2>
                <p class="text-xs text-gray-500">Ulasanmu akan otomatis masuk ke tab khusus Campaign!</p>
            </div>
            
            @auth
            <form action="{{ route('reviews.store') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <input type="hidden" name="is_campaign" value="1">
                
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-bold text-gray-700">Pilih Menu Campaign</label>
                    <select name="menu_id" class="p-3 border border-gray-300 rounded-lg cursor-pointer focus:ring-2 focus:ring-pink-500 outline-none" required>
                        <option value="" disabled selected>-- Pilih Menu Campaign --</option>
                        
                        @forelse($campaignMenus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @empty
                            <option value="" disabled>⚠️ Belum ada menu "Goguma" di Database Admin</option>
                        @endforelse
                        
                    </select>
                </div>

                <div class="flex flex-col gap-1 items-center my-2">
                    <label class="text-xs font-bold text-gray-700">Rating</label>
                    <div class="flex gap-2 text-2xl cursor-pointer text-gray-300" id="campStarContainer">
                        <i class="fas fa-star camp-star" data-value="1"></i>
                        <i class="fas fa-star camp-star" data-value="2"></i>
                        <i class="fas fa-star camp-star" data-value="3"></i>
                        <i class="fas fa-star camp-star" data-value="4"></i>
                        <i class="fas fa-star camp-star" data-value="5"></i>
                        <input type="hidden" name="rating" id="campRating" value="5" required>
                    </div>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-bold text-gray-700">Tulis Komentar</label>
                    <textarea name="comment" placeholder="Ceritakan rasa Goguma-nya!" rows="3" class="p-3 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-pink-500 outline-none" required></textarea>
                </div>

                <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-pink-200 mt-2">
                    Kirim Review Campaign
                </button>
            </form>
            @else
            <div class="text-center p-4">
                <p class="mb-4 text-red-500 font-bold">Ups! Login dulu ya buat ikutan lomba.</p>
                <a href="/" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-lg font-bold">Kembali & Login</a>
            </div>
            @endauth
        </div>
    </div>

    <script>
        // Logic Bintang Modal Campaign
        const campStars = document.querySelectorAll('.camp-star');
        const campRating = document.getElementById('campRating');
        let currentCamp = 5;

        function setCampColor(limit, color = '#f59e0b') {
            campStars.forEach(s => {
                if (s.getAttribute('data-value') <= limit) s.style.color = color;
                else s.style.color = '#d1d5db';
            });
        }
        setCampColor(currentCamp);

        campStars.forEach(star => {
            star.addEventListener('mouseover', function() { setCampColor(this.getAttribute('data-value'), '#fbbf24'); });
            star.addEventListener('mouseout', function() { setCampColor(currentCamp); });
            star.addEventListener('click', function() {
                currentCamp = this.getAttribute('data-value');
                campRating.value = currentCamp;
                setCampColor(currentCamp);
            });
        });
    </script>
</body>
</html>