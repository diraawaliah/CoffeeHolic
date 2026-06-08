<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoffeeHolic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&display=swap" rel="stylesheet">
    <style>
    /* 1. Grid Super Rapi */
    .picks-grid-rank {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        padding: 30px 10px;
    }

    /* 2. Kartu Estetik (Borderless & Melayang) */
    .aesthetic-card {
        position: relative;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: visible; 
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.5s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
    }

    .aesthetic-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(234, 179, 8, 0.15);
    }

    /* 3. WADAH SPOTLIGHT (Blob Mulus Mengikuti Kursor) */
    .aesthetic-card .glow-wrapper {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        border-radius: 20px;
        overflow: hidden;
        z-index: 0;
    }

    .aesthetic-card .glow-wrapper::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(600px circle at var(--mouse-x) var(--mouse-y), rgba(245, 158, 11, 0.12), transparent 40%);
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .aesthetic-card:hover .glow-wrapper::before {
        opacity: 1;
    }

    /* 4. Konten di Atas Cahaya */
    .card-content {
        position: relative;
        z-index: 1;
        padding: 40px 20px 30px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
    }

    /* 5. Gambar Kopi Mengambang */
    .card-img-floating {
        max-height: 100%; 
        max-width: 100%; 
        object-fit: contain; 
        transition: transform 0.5s ease;
        mix-blend-mode: multiply;
    }
    
    .aesthetic-card:hover .card-img-floating {
        transform: scale(1.08) rotate(2deg); 
    }

    /* 6. Lencana Floating Minimalis */
    .rank-badge {
        position: absolute;
        top: -15px;
        left: -15px;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        z-index: 10;
        border: 4px solid white;
        transition: transform 0.4s ease;
    }

    /* Tampilan Jam Kalender Aesthetic */
    .flatpickr-time {
        background-color: #fff1f0 !important; /* Warna latar jam peach kemerahan */
        border-radius: 0 0 10px 10px;
    }
    .flatpickr-time input {
        color: #ee4d2d !important; /* Angka jam berwarna orange khas CoffeeHolic */
        font-weight: 900 !important;
        font-size: 16px !important;
    }
    .flatpickr-time .numInputWrapper span.arrowUp:after {
        border-bottom-color: #ee4d2d !important;
    }
    .flatpickr-time .numInputWrapper span.arrowDown:after {
        border-top-color: #ee4d2d !important;
    }
    </style>
</head>
<body>

    <div class="top-bar">
        <div class="welcome-text">
            Welcome, <span>CoffeeHolic!</span>
        </div>
        
        <header class="top-bar-modern">
            <div class="container-nav">
                <div class="welcome-msg">
                    Welcome, <span class="brand-name">CoffeeHolic!</span>
                </div>
                
                <nav class="navigation-links">
                    <ul>
                        <li><a href="#trending-reviews">REVIEWS</a></li>
                        <li><a href="#find-favorites">FIND YOUR FAVORITES!</a></li>
                        <li><a href="#about-us">ABOUT US</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    </div>

    <header class="main-header">
        <div class="header-container">
            <h1 class="logo">COFFEE<span>HOLIC</span></h1>
            
            <form action="{{ url('/') }}#find-favorites" method="GET" class="search-bar" style="margin: 0; display: flex;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kopi, boba, atau cafe favoritmu..." required>
                <button type="submit" style="cursor: pointer;"><i class="fas fa-search"></i></button>
            </form>
            
            <div class="header-right">
                @auth
                    <div style="display: flex; align-items: center; gap: 15px; margin-right: 15px;">
                        <a href="{{ route('profile.edit') }}" style="display: flex; align-items: center; gap: 8px; background: #fff1f0; padding: 6px 15px; border-radius: 20px; color: #8b5a2b; font-weight: bold; font-size: 14px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.background='#ffdfd9'" onmouseout="this.style.background='#fff1f0'">
                            <i class="fas fa-user-cog" style="font-size: 18px;"></i>
                            Hai, {{ Auth::user()->name }}!
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" style="background: transparent; border: 1.5px solid #ef4444; color: #ef4444; padding: 6px 15px; border-radius: 20px; font-weight: bold; font-size: 12px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='#ef4444'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='#ef4444'">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="bg-[#FF7A45] hover:bg-[#E0602E] text-white px-6 py-2 rounded-full font-bold transition duration-300 shadow-md">
                        Login or Signup
                    </a>
                @endauth
                <div class="header-icons" style="display: flex; align-items: center; gap: 15px;">
                    @auth
                        @php
                            // Menghitung total kopi yang ada di keranjang user yang sedang login
                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                        @endphp
                        
                        <a href="/cart" style="position: relative; text-decoration: none; color: #333; transition: 0.3s;" onmouseover="this.style.color='#ee4d2d'" onmouseout="this.style.color='#333'">
                            <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                            @if($cartCount > 0)
                                <span style="position: absolute; top: -8px; right: -12px; background: #ee4d2d; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; box-shadow: 0 2px 4px rgba(238, 77, 45, 0.4);">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="document.getElementById('loginModal').style.display='flex'" style="color: #333; transition: 0.3s;" onmouseover="this.style.color='#ee4d2d'" onmouseout="this.style.color='#333'">
                            <i class="fas fa-shopping-cart" style="font-size: 20px;"></i>
                        </a>
                    @endauth

                    @auth
                        @php
                            // Cek apakah ada pesanan user yang belum selesai (pending / diproses)
                            $activeOrders = \App\Models\Order::where('user_id', Auth::id())
                                ->whereIn('status', ['pending', 'diproses'])
                                ->count();
                        @endphp
                        
                        <a href="{{ route('orders.history') }}" style="position: relative; color: #333; transition: 0.3s;" onmouseover="this.style.color='#ee4d2d'" onmouseout="this.style.color='#333'">
                            <i class="fas fa-bell" style="font-size: 20px;"></i>
                            @if($activeOrders > 0)
                                <span style="position: absolute; top: -2px; right: -4px; background: #ee4d2d; border-radius: 50%; width: 10px; height: 10px; border: 2px solid white; box-shadow: 0 0 5px rgba(238, 77, 45, 0.5);"></span>
                            @endif
                        </a>
                    @else
                        <a href="javascript:void(0)" onclick="document.getElementById('loginModal').style.display='flex'" style="color: #333; transition: 0.3s;" onmouseover="this.style.color='#ee4d2d'" onmouseout="this.style.color='#333'">
                            <i class="fas fa-bell" style="font-size: 20px;"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <nav class="main-nav">
        <ul class="nav-list">
            <li class="dropdown">
                <a href="#">Menu Kopi <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li><a href="#"><i class="fas fa-coffee"></i> Americano</a></li>
                        <li><a href="#"><i class="fas fa-mug-hot"></i> Latte</a></li>
                        <li><a href="#"><i class="fas fa-blender"></i> Cappuccino</a></li>
                        <li><a href="#"><i class="fas fa-ice-cream"></i> Es Kopi Susu Gula Aren</a></li>
                    </ul>
                </div>
            </li>
            <li class="dropdown">
                <a href="#">Minuman Kekinian <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content">
                    <ul class="dropdown-list">
                        <li><a href="#"><i class="fas fa-glass-martini-alt"></i> Mocktail</a></li>
                        <li><a href="#"><i class="fas fa-cubes"></i> Caramel Machiato</a></li>
                        <li><a href="#"><i class="fas fa-leaf"></i> Matcha Latte</a></li>
                        <li><a href="#"><i class="fas fa-apple-alt"></i> Fruit Tea</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#find-favorites">Rekomendasi</a></li>
            <li><a href="#about-us">About Us</a></li>
        </ul>
    </nav>

    <main>
        <section class="carousel-wrapper">
            <div class="carousel-container">
                <div class="carousel-slide" id="carouselSlide"></div>
            </div>
            <div class="carousel-dots" id="carouselDots"></div>
        </section>

        <section class="picks-section">
            <div class="container">
                <div class="picks-header">
                    <h2>On This Week Picks</h2>
                    <div class="header-line"></div>
                </div>

                <div class="picks-grid-rank" id="picksGridContainer"> 
                    @foreach($topPicks as $menu)
                    @php
                        $bgColors = ['#f59e0b', '#94a3b8', '#d97706', '#475569']; 
                        $badgeBg = $bgColors[$loop->index] ?? '#475569';
                    @endphp
                    <div class="aesthetic-card">
                        <div class="glow-wrapper"></div>
                        <div class="rank-badge" style="background: {{ $badgeBg }};">
                            <span style="font-size: 10px; line-height: 1; letter-spacing: 1px; text-transform: uppercase;">Top</span>
                            <span style="font-size: 22px; line-height: 1; font-family: 'Playfair Display', serif; font-weight: bold;">{{ $loop->iteration }}</span>
                        </div>
                        <div class="card-content">
                            <div style="height: 220px; width: 100%; display: flex; align-items: center; justify-content: center; margin-bottom: 25px;">
                                @if($menu->image_path)
                                    <img src="{{ asset($menu->image_path) }}" alt="{{ $menu->name }}" class="card-img-floating">
                                @else
                                    <i class="fas fa-coffee fa-4x text-gray-300"></i>
                                @endif
                            </div>
                            <p style="font-size: 11px; color: #a16207; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px;">
                                <i class="fas fa-map-marker-alt mr-1"></i> NAMA CAFE / BRAND
                            </p>
                            <h3 style="font-family: 'Playfair Display', serif; font-size: 24px; color: #1e293b; margin-bottom: 12px; line-height: 1.3;">{{ $menu->name }}</h3>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-bottom: 15px; font-size: 14px;">
                                <i class="fas fa-star" style="color: #f59e0b;"></i>
                                <span style="font-weight: 700; color: #f59e0b;">4.8</span>
                                <span style="color: #64748b;">(120 reviews)</span>
                            </div>
                            <p style="font-size: 20px; font-weight: 700; color: #e11d48; margin-bottom: 25px;">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

                            @auth
                                <form action="{{ route('cart.add', $menu->id) }}" method="POST" style="width: 100%; display: flex; justify-content: center; margin-top: auto;">
                                    @csrf
                                    <button type="submit" style="padding: 12px 30px; border-radius: 30px; border: 1.5px solid #a16207; color: #a16207; font-weight: 600; font-size: 14px; background: transparent; transition: all 0.3s ease; width: 80%; cursor: pointer;" onmouseover="this.style.background='#a16207'; this.style.color='white'; this.style.boxShadow='0 8px 15px rgba(161, 98, 7, 0.2)';" onmouseout="this.style.background='transparent'; this.style.color='#a16207'; this.style.boxShadow='none';">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </form>
                            @else
                                <button type="button" onclick="Swal.fire({icon: 'warning', title: 'Eits!', text: 'Login dulu yuk buat pesan kopi favoritmu!', confirmButtonColor: '#ee4d2d', confirmButtonText: 'Login Sekarang', customClass: {title: 'font-playfair'}}).then((res) => { if(res.isConfirmed) document.getElementById('loginModal').style.display = 'flex'; });" style="margin-top: auto; padding: 12px 30px; border-radius: 30px; border: 1.5px solid #a16207; color: #a16207; font-weight: 600; font-size: 14px; background: transparent; transition: all 0.3s ease; width: 80%; cursor: pointer;" onmouseover="this.style.background='#a16207'; this.style.color='white'; this.style.boxShadow='0 8px 15px rgba(161, 98, 7, 0.2)';" onmouseout="this.style.background='transparent'; this.style.color='#a16207'; this.style.boxShadow='none';">
                                    <i class="fas fa-plus"></i> Order Now
                                </button>
                            @endauth
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="campaign-section">
            <div class="container campaign-container">
                <div class="campaign-banner">
                    <div class="banner-card">
                        <img src="{{ asset('img/Goguma.jpg') }}" alt="Goguma Point Coffee">
                        <i class="fas fa-sparkles star-1"></i>
                        <i class="fas fa-sparkles star-2"></i>
                    </div>
                </div>
                <div class="campaign-info">
                    <h2 class="campaign-label">Try & Review</h2>
                    <h3 class="campaign-title">Try & Review Goguma Point Coffee</h3>
                    <p class="campaign-period">Period: 4 Apr 2026 - 14 Apr 2026</p>
                    <p class="campaign-desc">
                        Siapa yang bisa nolak perpaduan unik kopi premium dengan rasa manis gurih khas Goguma? 
                        Kali ini, CoffeeHolic mengajak kamu untuk jadi yang pertama mencoba Goguma Series dari Point Coffee secara GRATIS! 
                        Kami mencari 20 ulasan paling jujur dan kreatif untuk membantu komunitas menemukan rasa favorit mereka. 
                        Jangan sampai ketinggalan tren rasa terbaru tahun ini, yuk ikutan sekarang!
                    </p>
                    <a href="{{ route('campaign.index') }}" class="join-btn">Join Now</a>
                </div>
            </div>
        </section>

        <section id="find-favorites" class="favorites-section">
            <div class="container">
                <div class="section-header-aesthetic">
                    <h2 class="playfair-title">
                        @if(request('search'))
                            Hasil Pencarian: "{{ request('search') }}"
                        @else
                            Find Your Favorites!
                        @endif
                    </h2>
                    
                    @if(request('search'))
                        <div style="text-align: center; margin-top: 10px;">
                            <a href="/" style="font-size: 13px; color: #ee4d2d; text-decoration: underline; font-weight: bold;">Hapus Pencarian & Tampilkan Semua</a>
                        </div>
                    @endif
                </div>
                
                @if($allMenus->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #94a3b8; font-style: italic;">
                        <i class="fas fa-search-minus fa-3x" style="margin-bottom: 15px; color: #cbd5e1;"></i>
                        <p>Waduh, menu "{{ request('search') }}" belum tersedia di CoffeeHolic.</p>
                    </div>
                @endif
                <div class="favorites-slider-wrapper">
                    <button class="nav-arrow prev" id="prevFav"><i class="fas fa-chevron-left"></i></button>
                    <button class="nav-arrow next" id="nextFav"><i class="fas fa-chevron-right"></i></button>

                    <div class="favorites-track" id="favoritesTrack" style="display: flex; flex-wrap: nowrap; transition: transform 0.5s ease; padding: 10px 0;">
                        @foreach($allMenus as $menu)
                        <div class="fav-card" style="flex: 0 0 calc(25% - 20px); min-width: 250px; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-right: 20px; border: 1px solid #f3f4f6; transition: all 0.3s; display: flex; flex-direction: column;" onmouseover="this.style.boxShadow='0 10px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.05)'">
                            <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; padding: 25px;">
                                @if($menu->image_path)
                                    <img src="{{ asset($menu->image_path) }}" alt="{{ $menu->name }}" style="width: 100%; height: 100%; object-fit: contain; object-position: center; mix-blend-mode: multiply;">
                                @else
                                    <i class="fas fa-glass-cheers fa-3x" style="color: #9ca3af;"></i>
                                @endif
                            </div>
                            <div style="padding: 0 20px 20px 20px; text-align: center; display: flex; flex-direction: column; flex-grow: 1;">
                                <p style="font-size: 10px; color: #a16207; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px;">
                                    <i class="fas fa-map-marker-alt mr-1"></i> NAMA CAFE / BRAND
                                </p>
                                <h3 style="font-family: 'Playfair Display', serif; font-size: 18px; color: #333; margin-bottom: 5px; min-height: 44px; display: flex; align-items: center; justify-content: center;">{{ $menu->name }}</h3>
                                <div style="margin-bottom: 15px;">
                                    <p style="color: #e11d48; font-weight: bold; font-size: 16px; background: #fff1f0; padding: 5px 15px; border-radius: 10px; display: inline-block;">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                </div>
                                <div style="flex-grow: 1;"></div>

                                @auth
                                    <form action="{{ route('cart.add', $menu->id) }}" method="POST" style="width: 100%;">
                                        @csrf
                                        <button type="submit" style="width: 100%; padding: 10px; border-radius: 30px; border: 1.5px solid #a16207; color: #a16207; font-weight: 600; font-size: 13px; background: transparent; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#a16207'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='#a16207';">
                                            <i class="fas fa-plus"></i> Add
                                        </button>
                                    </form>
                                @else
                                    <button type="button" onclick="Swal.fire({icon: 'warning', title: 'Eits!', text: 'Login dulu yuk buat pesan kopi favoritmu!', confirmButtonColor: '#ee4d2d', confirmButtonText: 'Login Sekarang', customClass: {title: 'font-playfair'}}).then((res) => { if(res.isConfirmed) document.getElementById('loginModal').style.display = 'flex'; });" style="width: 100%; padding: 10px; border-radius: 30px; border: 1.5px solid #a16207; color: #a16207; font-weight: 600; font-size: 13px; background: transparent; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#a16207'; this.style.color='white';" onmouseout="this.style.background='transparent'; this.style.color='#a16207';">
                                        <i class="fas fa-plus"></i> Order Now
                                    </button>
                                @endauth
                            </div>
                        </div>
                        @endforeach
                    </div>
                <div class="favorites-dots" id="favoritesDots"></div>
            </div>
        </section>

        <section id="reviews-section" style="padding-top: 50px;">
            <div class="review-header-centered">
                <h2>Tell the community 'bout your taste.</h2>
                <button id="writeReviewBtn" class="action-btn-centered" onclick="document.getElementById('reviewModal').style.display='flex'">
                    <i class="fas fa-pen"></i> Tulis Review
                </button>
            </div>
        </section>

        <section id="trending-reviews" class="trending-section">
            <div class="container">
                <div class="trending-header">
                    <h2 class="playfair-title">Trending Reviews</h2>
                    </div>
                
                <div class="review-list-container" id="trendingReviewGrid">
                    
                    <div id="tab-terbaru" style="display: block;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px 0;">
                            @forelse($reviews as $review)
                            <div style="background: #fff; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.08)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.03)';">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #fff1f0; color: #ee4d2d; display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 16px;">
                                            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 14px; color: #1e293b; font-weight: bold;">{{ $review->user->name ?? 'Anonim' }}</h4>
                                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    <div style="color: #f59e0b; font-size: 12px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star" style="color: #e2e8f0;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <div style="margin-bottom: 12px;">
                                    <span style="background: #f8fafc; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; color: #ee4d2d; border: 1px solid #f1f5f9;">
                                        <i class="fas fa-coffee mr-1"></i> {{ $review->menu ? $review->menu->name : 'Menu Terhapus' }}
                                    </span>
                                </div>

                                <p style="margin: 0; font-size: 13px; color: #475569; line-height: 1.6; font-style: italic;">
                                    "{{ $review->comment }}"
                                </p>
                            </div>
                            @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 50px 20px; color: #94a3b8; background: white; border-radius: 15px; border: 1px dashed #cbd5e1;">
                                <i class="fas fa-comment-dots fa-3x" style="margin-bottom: 15px; color: #e2e8f0;"></i>
                                <h3 style="margin: 0 0 5px 0; font-family: 'Playfair Display', serif; color: #475569;">Belum Ada Ulasan</h3>
                                <p style="margin: 0; font-size: 14px;">Jadilah CoffeeHolic pertama yang membagikan ceritamu!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <div id="tab-campaign" style="display: none; padding: 20px 0;">
                        
                        <div style="background: linear-gradient(135deg, #fff0f2 0%, #ffe4e6 100%); border-radius: 15px; padding: 40px 20px; text-align: center; border: 2px dashed #f472b6; position: relative; overflow: hidden; margin-bottom: 30px;">
                            <i class="fas fa-gift fa-3x" style="color: #db2777; margin-bottom: 15px;"></i>
                            <h3 style="font-family: 'Playfair Display', serif; color: #9d174d; font-size: 26px; margin-bottom: 10px;">Goguma Point Coffee Challenge!</h3>
                            <p class="text-pink-700 font-bold mb-4">Lihat ulasan para CoffeeHolic yang sudah berpartisipasi di bawah ini!</p>
                            <a href="{{ route('campaign.index') }}" style="background: #db2777; color: white; border: none; padding: 10px 25px; border-radius: 30px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-block;">Ikut Lomba</a>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                            @forelse($campaignReviews as $campReview)
                                <div style="background: #fff; border-radius: 15px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #fbcfe8; position: relative; overflow: hidden;">
                                    
                                    <div style="position: absolute; top: 0; right: 0; background: #f472b6; color: white; font-size: 10px; font-weight: bold; padding: 4px 12px; border-bottom-left-radius: 10px;">
                                        CAMPAIGN ENTRY
                                    </div>

                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                                        <div style="display: flex; gap: 12px; align-items: center;">
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #fdf2f8; color: #db2777; display: flex; justify-content: center; align-items: center; font-weight: bold; font-size: 16px;">
                                                {{ strtoupper(substr($campReview->user->name ?? 'A', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 style="margin: 0; font-size: 14px; color: #1e293b; font-weight: bold;">{{ $campReview->user->name ?? 'Anonim' }}</h4>
                                                <p style="margin: 0; font-size: 11px; color: #94a3b8;">{{ $campReview->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>

                                        <div style="color: #f59e0b; font-size: 12px; margin-top: 5px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $campReview->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star" style="color: #e2e8f0;"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <div style="margin-bottom: 12px;">
                                        <span style="background: #fdf2f8; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: bold; color: #db2777; border: 1px solid #fbcfe8;">
                                            <i class="fas fa-gift mr-1"></i> {{ $campReview->menu ? $campReview->menu->name : 'Menu Terhapus' }}
                                        </span>
                                    </div>

                                    <p style="margin: 0; font-size: 13px; color: #475569; line-height: 1.6; font-style: italic;">
                                        "{{ $campReview->comment }}"
                                    </p>
                                </div>
                            @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #f472b6; background: #fff0f2; border-radius: 15px; border: 1px dashed #fbcfe8;">
                                <i class="fas fa-star-half-alt fa-3x mb-3"></i>
                                <h3 style="margin: 0; font-family: 'Playfair Display', serif;">Belum ada entry Campaign</h3>
                                <p style="margin: 0; font-size: 13px;">Review pertamamu bisa jadi tiket menangin e-voucher!</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="about-us" class="about-section">
            <div class="container">
                <div class="section-header-centered">
                    <h2 class="playfair-title">Meet the Creators</h2>
                    <div class="header-line"></div>
                </div>

                <div class="creators-grid">
                    <div class="about-card-modern">
                        <div class="profile-frame">
                            <img src="{{ asset('img/Dira.png') }}" alt="Indira" class="profile-img-aesthetic">
                        </div>
                        <div class="about-content">
                            <h4 class="about-label">Creator I</h4>
                            <h3 class="creator-name">Indira Putri Ayu Awaliah</h3>
                            <p class="creator-status">3rd Year Broadband Multimedia @ PNJ</p>
                            <p class="about-desc">
                                Mahasiswi Elektro yang percaya bahwa kopi enak adalah bahan bakar terbaik untuk coding dan desain.
                            </p>
                            <div class="about-socials">
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="about-card-modern">
                        <div class="profile-frame">
                            <img src="{{ asset('img/Erna foto.jpg') }}" alt="Partner" class="profile-img-aesthetic">
                        </div>
                        <div class="about-content">
                            <h4 class="about-label">Creator II</h4>
                            <h3 class="creator-name">Ernawati</h3>
                            <p class="creator-status">3rd Year Broadband Multimedia @ PNJ</p>
                            <p class="about-desc">
                                Pecinta boba dan penikmat senja yang bertugas memastikan setiap konten di COFFEEHOLIC tetap fresh.
                            </p>
                            <div class="about-socials">
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fas fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="aesthetic-footer">
        <div class="footer-wave"></div> 
        <div class="container footer-content">
            <div class="footer-info">
                <h1 class="logo-footer">Coffee<span>Holic</span></h1>
                <p class="tagline">Elevating your coffee experience, one review at a time. Bergabunglah dengan komunitas pecinta kafein terbesar di PNJ.</p>
                <div class="social-glass">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" aria-label="Email"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <div class="footer-nav">
                <h4>Discover</h4>
                <ul>
                    <li><a href="#reviews-section">Trending Reviews</a></li>
                    <li><a href="#find-favorites">Editor's Choice</a></li>
                    <li><a href="#">Article & News</a></li>
                    <li><a href="#about-us">Our Story</a></li>
                </ul>
            </div>

            <div class="footer-nav">
                <h4>Beverage Guide</h4>
                <ul>
                    <li><a href="#">Espresso Based</a></li>
                    <li><a href="#">Non-Coffee Series</a></li>
                    <li><a href="#">Boba & Jelly</a></li>
                    <li><a href="#">Manual Brew</a></li>
                </ul>
            </div>

            <div class="footer-subscribe">
                <h4>Stay Caffeinated</h4>
                <p>Dapatkan info promo & menu baru langsung di emailmu.</p>
                <div class="subscribe-box">
                    <input type="email" placeholder="Your email...">
                    <button><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <p>Handcrafted with <i class="fas fa-heart" style="color: #ee4d2d;"></i> by <strong>Erna & Indira</strong> | Broadband Multimedia &copy; 2026</p>
        </div>
    </footer>

    <div id="reviewModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); backdrop-filter:blur(8px); z-index:10000; justify-content:center; align-items:center;">
        <div class="modal-box-aesthetic" style="background:#fff; width:90%; max-width:450px; padding:30px; border-radius:20px; position:relative; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <button onclick="document.getElementById('reviewModal').style.display='none'" style="position:absolute; top:15px; right:15px; background:#eee; border:none; width:30px; height:30px; border-radius:50%; cursor:pointer;">&times;</button>
            
            <div style="text-align:center; margin-bottom:20px;">
                <h2 style="font-family:'Playfair Display', serif; font-size:24px; margin-bottom:5px;">Bagikan Pengalamanmu!</h2>
                <p style="font-size:12px; color:#666;">Review jujurmu sangat berarti bagi sesama CoffeeHolic ✨</p>
            </div>
            
            @auth
            <form action="{{ route('reviews.store') }}" method="POST" style="display:flex; flex-direction:column; gap:15px;">
                @csrf
                
                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:12px; font-weight:bold;">Pilih Kopi yang Direview</label>
                    <select name="menu_id" style="padding:10px; border:1px solid #ddd; border-radius:8px; cursor:pointer;" required>
                        <option value="" disabled selected>-- Pilih Menu --</option>
                        @foreach($allMenus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display:flex; flex-direction:column; gap:5px; align-items:center; margin: 10px 0;">
                    <label style="font-size:12px; font-weight:bold;">Berikan Rating</label>
                    <div class="star-rating" id="starRatingContainer" style="display:flex; gap:10px; font-size:24px; cursor:pointer; color:#ccc;">
                        <i class="fas fa-star star-btn" data-value="1"></i>
                        <i class="fas fa-star star-btn" data-value="2"></i>
                        <i class="fas fa-star star-btn" data-value="3"></i>
                        <i class="fas fa-star star-btn" data-value="4"></i>
                        <i class="fas fa-star star-btn" data-value="5"></i>
                        <input type="hidden" name="rating" id="reviewRating" value="5" required>
                    </div>
                </div>

                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:12px; font-weight:bold;">Tulis Komentar</label>
                    <textarea name="comment" placeholder="Ceritakan rasa, aroma, dan suasananya..." rows="3" style="padding:10px; border:1px solid #ddd; border-radius:8px; resize:none; font-family:inherit;" required></textarea>
                </div>

                <button type="submit" style="background:#ee4d2d; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer; transition:0.3s;" onmouseover="this.style.background='#d03e20'" onmouseout="this.style.background='#ee4d2d'">
                    Kirim Review Sekarang
                </button>
            </form>
            @else
            <div style="text-align:center; padding:20px;">
                <p style="margin-bottom:15px; color:#ef4444; font-weight:bold;">Kamu harus login dulu untuk menulis review!</p>
                <button type="button" onclick="document.getElementById('reviewModal').style.display='none'; document.getElementById('loginModal').style.display='flex';" style="background:#ee4d2d; color:white; border:none; padding:10px 20px; border-radius:8px; font-weight:bold; cursor:pointer;">
                    Login Sekarang
                </button>
            </div>
            @endauth
        </div>
    </div>

    <div id="loginModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); backdrop-filter:blur(8px); z-index:10000; justify-content:center; align-items:center;">
        <div class="modal-box-aesthetic" style="background:#fff; width:90%; max-width:400px; padding:30px; border-radius:20px; position:relative; z-index:10001;">
            <button id="closeLoginModal" style="position:absolute; top:15px; right:15px; background:#eee; border:none; width:30px; height:30px; border-radius:50%; cursor:pointer;">&times;</button>
            <div id="loginContent">
                <div style="text-align:center; margin-bottom:20px;">
                    <h2 style="font-family:'Playfair Display', serif; font-size:24px; margin-bottom:5px;">Welcome Back!</h2>
                    <p style="font-size:12px; color:#666;">Login untuk akses fitur CoffeeHolic</p>
                </div>
                <form action="{{ route('login') }}" method="POST" class="modal-form" style="display:flex; flex-direction:column; gap:15px;">
                    @csrf
                    @if ($errors->any())
                        <div style="color: red; font-size: 12px; margin-bottom: 10px;">{{ $errors->first() }}</div>
                    @endif
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email kamu" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Password</label>
                        <input type="password" name="password" placeholder="••••••••" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required>
                    </div>
                    <button type="submit" style="background:#ee4d2d; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer;">Login Sekarang</button>
                </form>
                <p style="text-align:center; font-size:12px; margin-top:15px; color:#666;">
                    Belum punya akun? <a href="javascript:void(0)" id="toSignup" style="color:#ee4d2d; font-weight:bold; text-decoration:none;">Daftar di sini</a>
                </p>
            </div>
            <div id="signupContent" style="display:none;">
                <div style="text-align:center; margin-bottom:20px;">
                    <h2 style="font-family:'Playfair Display', serif; font-size:24px; margin-bottom:5px;">Join Us!</h2>
                    <p style="font-size:12px; color:#666;">Buat akun untuk mulai mereview kopi favoritmu</p>
                </div>
                <form action="{{ route('register') }}" method="POST" class="modal-form" style="display:flex; flex-direction:column; gap:12px;">
                    @csrf
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Nama kamu" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Email</label>
                        <input type="email" name="email" placeholder="Email kamu" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required>
                    </div>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                        <div style="display:flex; flex-direction:column; gap:5px;">
                            <label style="font-size:12px; font-weight:bold;">Password Baru</label>
                            <input type="password" name="password" placeholder="Min. 8 karakter" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required minlength="8">
                        </div>
                        <div style="display:flex; flex-direction:column; gap:5px;">
                            <label style="font-size:12px; font-weight:bold;">Ulangi Password</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password" style="padding:10px; border:1px solid #ddd; border-radius:8px;" required minlength="8">
                        </div>
                    </div>
                    <button type="submit" style="background:#ee4d2d; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer; margin-top:5px;">Daftar Akun</button>
                </form>
                <p style="text-align:center; font-size:12px; margin-top:15px; color:#666;">
                    Sudah punya akun? <a href="javascript:void(0)" id="toLogin" style="color:#ee4d2d; font-weight:bold; text-decoration:none;">Login di sini</a>
                </p>
            </div>
        </div>
    </div>

    <div id="checkoutModal" class="modal-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center; backdrop-filter: blur(3px);">
        <div style="background:#fff; width:90%; max-width:400px; padding:30px; border-radius:15px; position:relative; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <button type="button" onclick="document.getElementById('reviewModal').style.display='none'" style="position:absolute; top:15px; right:15px; background:#f3f4f6; border:none; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:20px; color:#6b7280; z-index: 10002; display: flex; align-items: center; justify-content: center; transition: 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">&times;</button>
            <h2 style="font-family:'Playfair Display', serif; margin-bottom:5px; font-size:22px;">Detail Pesanan</h2>
            <p id="checkoutMenuName" style="font-weight:bold; color:#a16207; font-size:18px; margin-bottom:2px;">Nama Kopi</p>
            <p id="checkoutMenuPrice" style="color:#666; font-size:14px; margin-bottom:20px; font-weight:bold;">Rp 0</p>

            <form id="checkoutForm" method="POST" style="display:flex; flex-direction:column; gap:15px;">
                @csrf
                
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Tipe Pesanan</label>
                        <select name="order_type" id="orderType" style="padding:10px; border:1px solid #ddd; border-radius:8px; cursor:pointer;" onchange="togglePickupTime()">
                            <option value="dine-in">Dine-in (Di Sini)</option>
                            <option value="takeaway">Takeaway (Bungkus)</option>
                            <option value="pickup">Pickup (Ambil Nanti)</option>
                        </select>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:5px;">
                        <label style="font-size:12px; font-weight:bold;">Pembayaran</label>
                        <select name="payment_method" style="padding:10px; border:1px solid #ddd; border-radius:8px; cursor:pointer;">
                            <option value="qris">QRIS / E-Wallet</option>
                            <option value="cash">Cash di Kasir</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>
                </div>

                <div id="pickupTimeContainer" style="display:none; flex-direction:column; gap:5px;">
                    <label style="font-size:12px; font-weight:bold;">Rencana Jam Ambil</label>
                    <input type="text" id="flatpickr-input" name="pickup_time" placeholder="Pilih tanggal dan jam..." style="padding:10px; border:1px solid #ddd; border-radius:8px; background-color: #f9fafb;">
                </div>

                <div style="display:flex; flex-direction:column; gap:5px;">
                    <label style="font-size:12px; font-weight:bold;">Catatan (Opsional)</label>
                    <textarea name="notes" placeholder="Misal: Less sugar, esnya dikit aja ya kak..." style="padding:10px; border:1px solid #ddd; border-radius:8px; height:60px; resize:none; font-family: inherit;"></textarea>
                </div>

                <button type="submit" style="background:#ee4d2d; color:white; border:none; padding:12px; border-radius:8px; font-weight:bold; cursor:pointer; margin-top:10px; transition: 0.3s;" onmouseover="this.style.background='#d03e20'" onmouseout="this.style.background='#ee4d2d'">
                    Konfirmasi Pesanan
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // --- SCRIPT GLOW EFFECT ---
        document.addEventListener('DOMContentLoaded', function() {
            const gridContainer = document.getElementById('picksGridContainer');
            if(gridContainer) {
                gridContainer.addEventListener('mousemove', function(e) {
                    const cards = document.querySelectorAll('.aesthetic-card');
                    cards.forEach(card => {
                        const rect = card.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        card.style.setProperty('--mouse-x', `${x}px`);
                        card.style.setProperty('--mouse-y', `${y}px`);
                    });
                });
            }
        });

        // --- SCRIPT SWEETALERT (POP-UP NOTIF) ---
        document.addEventListener("DOMContentLoaded", function() {
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Gagal Masuk',
                    text: '{{ $errors->first() }}',
                    confirmButtonColor: '#ee4d2d',
                    confirmButtonText: 'Coba Lagi',
                    background: '#ffffff',
                    customClass: { title: 'font-playfair' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('loginModal').style.display = 'flex';
                    }
                });
            @endif

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Yeay!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: '#ffffff',
                    customClass: { title: 'font-playfair' }
                });
            @endif
        });

        // --- SCRIPT MODAL CHECKOUT ---
        function openCheckout(id, name, price) {
            document.getElementById('checkoutMenuName').innerText = name;
            document.getElementById('checkoutMenuPrice').innerText = 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('checkoutForm').action = '/order/' + id;
            document.getElementById('checkoutModal').style.display = 'flex';
        }

        function togglePickupTime() {
            const type = document.getElementById('orderType').value;
            const container = document.getElementById('pickupTimeContainer');
            if (type === 'pickup') {
                container.style.display = 'flex';
            } else {
                container.style.display = 'none';
            }
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Aktifkan Kalender Flatpickr
        flatpickr("#flatpickr-input", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today", 
            time_24hr: true,
            disableMobile: "true" 
        });
    </script>

    <script>
        // SCRIPT RATING BINTANG & UX MODAL
        document.addEventListener("DOMContentLoaded", function() {
            // -- 1. Penangan UX Tombol Close "X" --
            const closeReviewBtn = document.getElementById('closeReviewModal'); 
            if (closeReviewBtn) {
                closeReviewBtn.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    document.getElementById('reviewModal').style.display = 'none';
                });
            }

            // -- 2. Penangan Estetika Bintang (Hover & Click) --
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('reviewRating');
            let currentRating = ratingInput.value; 

            function setStarsColor(limit, color = '#f59e0b') {
                stars.forEach(s => {
                    const val = s.getAttribute('data-value');
                    if (val <= limit) {
                        s.style.color = color;
                    } else {
                        s.style.color = '#ccc'; 
                    }
                });
            }

            setStarsColor(currentRating);

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const hoverValue = this.getAttribute('data-value');
                    setStarsColor(hoverValue, '#fbbf24'); 
                });

                star.addEventListener('mouseout', function() {
                    setStarsColor(currentRating);
                });

                star.addEventListener('click', function() {
                    currentRating = this.getAttribute('data-value');
                    ratingInput.value = currentRating;
                    setStarsColor(currentRating);
                });
            });
        });

        // SCRIPT TAB SWITCHER (TRENDING REVIEWS)
        function switchReviewTab(tabName) {
            // Ambil elemen wadah
            const tabTerbaru = document.getElementById('tab-terbaru');
            const tabCampaign = document.getElementById('tab-campaign');
            
            // Ambil tombol tab-nya (yang ada di dalam .review-tabs)
            const btns = document.querySelectorAll('.review-tabs .tab-btn');

            // Hapus class 'active' dari semua tombol terlebih dahulu
            btns.forEach(btn => btn.classList.remove('active'));

            if (tabName === 'terbaru') {
                tabTerbaru.style.display = 'block';
                tabCampaign.style.display = 'none';
                btns[0].classList.add('active'); // Aktifkan tombol pertama
            } else if (tabName === 'campaign') {
                tabTerbaru.style.display = 'none';
                tabCampaign.style.display = 'block';
                btns[1].classList.add('active'); // Aktifkan tombol kedua
            }
        }
    </script>

</body>
</html>