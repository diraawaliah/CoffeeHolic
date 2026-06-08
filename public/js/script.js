/* ==========================================
   1. DATA CENTRAL
   ========================================== */
const bannerImages = ['/img/carousel1.png', '/img/carousel2.png', '/img/carousel3.png'];

const myFavorites = [
    { brand: "Cafe Luwak", name: "Iced Caramel Macchiato", price: "35.000", rating: 4.8, img: "/img/2.png" },
    { brand: "Chatime", name: "Boba Milk Tea", price: "28.000", rating: 4.9, img: "/img/1.png" },
    { brand: "Starbucks", name: "Americano", price: "40.000", rating: 4.5, img: "/img/3.png" },
    { brand: "Kopi Kenangan", name: "Es Kopi Gula Aren", price: "22.000", rating: 4.7, img: "/img/4.png" },
    { brand: "Fore Coffee", name: "Matcha Latte", price: "32.000", rating: 4.6, img: "/img/5.png" },
    { brand: "Tuku", name: "Es Kopi Susu Tetangga", price: "20.000", rating: 4.9, img: "/img/tuku.png" },
    { brand: "Janji Jiwa", name: "Kopi Susu", price: "18.000", rating: 4.6, img: "/img/kopsus.png" },
    { brand: "Anomali", name: "Hot Cappuccino", price: "38.000", rating: 4.7, img: "/img/cappucino.png" },
    { brand: "Point Coffee", name: "Cendol", price: "30.000", rating: 4.8, img: "/img/cendol.png" },
    { brand: "Excelso", name: "Avocado Coffee", price: "55.000", rating: 4.8, img: "/img/alpukat.png" }
]

const dataTrending = {
    terbaru: [
        { name: "Zeus", menu: "Aren Latte @ Kopi Kenangan", rating: 5, date: "2 jam yang lalu", text: "Kopinya strong, arennya berasa banget. Pas buat nemenin nugas!", img: "https://i.pravatar.cc/150?u=indira" },
        { name: "Paquito", menu: "Americano @ Starbucks", rating: 4, date: "5 jam yang lalu", text: "Segar banget siang-siang minum ini. Pelayanannya cepat.", img: "https://i.pravatar.cc/150?u=budi" },
        { name: "Zefanya", menu: "Matcha @ Point Coffee", rating: 5, date: "1 hari yang lalu", text: "Matchanya gak terlalu manis, pas buat yang suka rasa otentik.", img: "https://i.pravatar.cc/150?u=siti" }
    ],
    campaign: [
        { name: "Shah Rukh Khan", menu: "Try & Review: Oatmilk Series", rating: 5, date: "April 2026", text: "Teksturnya creamy banget, gak nyangka susu nabati bisa seenak ini!", img: "https://i.pravatar.cc/150?u=agus" },
        { name: "Tyla", menu: "Try & Review: New Boba", rating: 4, date: "Maret 2026", text: "Bobanya kenyal tapi ukurannya agak kecil. Overall oke!", img: "https://i.pravatar.cc/150?u=rina" },
        { name: "Nadine Amizah", menu: "Try & Review: Cold Brew", rating: 5, date: "Maret 2026", text: "Sangat smooth! Gak bikin perut kembung. Recommended.", img: "https://i.pravatar.cc/150?u=dewi" }
    ]
};

/* ==========================================
   2. LOGIKA SISTEM
   ========================================== */

   // Fungsi untuk Smooth Scroll yang lebih presisi
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Stop gerakan loncat tiba-tiba

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            // Tentukan posisi tujuan (dikurangi tinggi header agar pas)
            const headerHeight = 80; // Sesuaikan tinggi header
            const targetPosition = targetElement.offsetTop - headerHeight;

            // Perintah scroll halus
            window.scrollTo({
                top: targetPosition,
                behavior: "smooth"
            });
        }
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah loncatan instan

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            // Kita kasih offset 80-100px supaya judulnya tidak ketutup header
            const headerOffset = 90; 
            const elementPosition = targetElement.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth" // Inilah rahasia gerakan halusnya!
            });
        }
    });
});

   // --- Banner Carousel ---
let bannerCounter = 0;
function setupBanner() {
    const slide = document.getElementById('carouselSlide');
    const dots = document.getElementById('carouselDots');
    if(!slide || !dots) return;

    bannerImages.forEach((src, i) => {
        const img = document.createElement('img');
        img.src = src;
        slide.appendChild(img);
        const dot = document.createElement('div');
        dot.className = i === 0 ? 'dot active' : 'dot';
        dot.onclick = () => { bannerCounter = i; updateBanner(); };
        dots.appendChild(dot);
    });

    setInterval(() => {
        bannerCounter = (bannerCounter + 1) % bannerImages.length;
        updateBanner();
    }, 4000);
}

// DATA UNTUK WEEKLY PICKS
const weeklyPicksRank = [
    { rank: 1, brand: "Kopi Kenangan", name: "Es Kopi Kenangan Mantan", rating: 4.9, reviews: 2150, image: "/img/1.png", userImg: "https://i.pravatar.cc/150?u=indira" },
    { rank: 2, brand: "Chatime", name: "Hazelnut Chocolate Milk Tea", rating: 4.8, reviews: 1890, image: "/img/2.png", userImg: "https://i.pravatar.cc/150?u=boba" },
    { rank: 3, brand: "Starbucks", name: "Caramel Macchiato Iced", rating: 4.7, reviews: 3100, image: "/img/3.png", userImg: "https://i.pravatar.cc/150?u=coffee" },
    { rank: 4, brand: "Point Coffee", name: "Goguma Latte Series", rating: 4.6, reviews: 950, image: "/img/4.png", userImg: "https://i.pravatar.cc/150?u=matcha" }
];

/* DIMATIKAN SEMENTARA KARENA SUDAH PAKAI LARAVEL BLADE
function renderWeeklyPicksRank() {
    //const picksGrid = document.getElementById('picksGrid');
    if(!picksGrid) {
        console.error("ID picksGrid tidak ditemukan!");
        return;
    }

    picksGrid.innerHTML = ''; // Bersihkan dulu

    weeklyPicksRank.forEach(item => {
        const card = document.createElement('div');
        card.className = 'pick-card-rank';
        card.innerHTML = `
            <div class="reviewer-avatar-picks">
                <img src="${item.userImg}" alt="user">
            </div>
            <div class="rank-badge rank-${item.rank}">
                <span class="rank-text">Top</span>
                <span class="rank-number">${item.rank}</span>
            </div>
            <img src="${item.image}" class="item-img" alt="${item.name}">
            <p class="brand-name">${item.brand}</p>
            <p class="product-name">${item.name}</p>
            <div class="rating-row">
                <i class="fas fa-star"></i> ${item.rating} <span>(${item.reviews} reviews)</span>
            </div>
        `;
        picksGrid.appendChild(card);
    });
}
*/

// PASTIKAN INI DIPANGGIL DI PALING BAWAH
window.addEventListener('load', () => {
    // renderWeeklyPicksRank();
    // Panggil juga fungsi lainnya...
});

function updateBanner() {
    const slide = document.getElementById('carouselSlide');
    const dots = document.querySelectorAll('#carouselDots .dot');
    const gap = (20 / slide.clientWidth) * 100;
    slide.style.transform = `translateX(${-bannerCounter * (100 + gap)}%)`;
    dots.forEach((d, i) => d.classList.toggle('active', i === bannerCounter));
}

// --- Favorites Slider ---
let currentFavSlide = 0;
function setupFavorites() {
    const track = document.getElementById('favoritesTrack');
    const dotsContainer = document.getElementById('favoritesDots');
    const prevBtn = document.getElementById('prevFav');
    const nextBtn = document.getElementById('nextFav');
    
    if(!track) return;

    // Hitung berapa banyak kartu yang dihasilkan Laravel
    const cards = track.querySelectorAll('.fav-card');
    if(cards.length === 0) return;

    // Hitung jumlah kelompok slide (Asumsi 1 layar muat 4 kartu)
    const totalSlides = Math.ceil(cards.length / 4);

    function moveSlide(index) {
        currentFavSlide = index;
        
        // Agar bisa berputar tanpa henti (infinite loop manual)
        if (currentFavSlide >= totalSlides) currentFavSlide = 0;
        if (currentFavSlide < 0) currentFavSlide = totalSlides - 1;

        // Geser track ke kiri sejauh 100% dikali urutan slide
        track.style.transform = `translateX(-${currentFavSlide * 100}%)`;
        
        // Nyalakan dot yang sesuai
        if(dotsContainer) {
            document.querySelectorAll('.fav-dot').forEach((d, idx) => d.classList.toggle('active', idx === currentFavSlide));
        }
    }

    // Sambungkan ke tombol panah
    if(nextBtn) nextBtn.onclick = () => moveSlide(currentFavSlide + 1);
    if(prevBtn) prevBtn.onclick = () => moveSlide(currentFavSlide - 1);

    // Bikin titik (dots) secara otomatis berdasarkan jumlah slide
    if(dotsContainer) {
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalSlides; i++) {
            const dot = document.createElement('div');
            dot.className = i === 0 ? 'fav-dot active' : 'fav-dot';
            dot.onclick = () => moveSlide(i);
            dotsContainer.appendChild(dot);
        }
    }
}

// --- Trending Review Tab ---
function switchReviewTab(category) {
    const grid = document.getElementById('trendingReviewGrid');
    if (!grid) return;
    grid.innerHTML = '';
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.innerText.toLowerCase().includes(category.toLowerCase())) btn.classList.add('active');
    });
    dataTrending[category].forEach(item => {
        const card = document.createElement('div');
        card.className = 'review-card-modern';
        card.style.cssText = "display:flex; gap:20px; padding:20px; border:1px solid #eee; border-radius:15px; margin-bottom:15px; background:#fff;";
        card.innerHTML = `
            <img src="${item.img}" style="width:60px; height:60px; border-radius:50%; object-fit:cover; border: 2px solid #ee4d2d;">
            <div>
                <h4 style="color:#ee4d2d; margin:0 0 5px 0;">${item.menu}</h4>
                <div style="color:#f1c40f; font-size:12px; margin-bottom:5px;">
                    ${'★'.repeat(item.rating)}${'☆'.repeat(5-item.rating)} <span style="color:#888;">by ${item.name}</span>
                </div>
                <p style="font-size:11px; color:#aaa; margin-bottom:8px;">${item.date}</p>
                <p style="font-size:13px; color:#555; font-style:italic;">"${item.text}"</p>
            </div>
        `;
        grid.appendChild(card);
    });
}

// --- Modal & Smooth Stars ---
// --- Modal & Smooth Stars (REVISI AGAR PASTI TERBUKA) ---
function setupModalAndStars() {
    const modalOverlay = document.getElementById('reviewModal');
    const writeBtn = document.getElementById('writeReviewBtn');
    const closeBtn = document.getElementById('closeReviewModal');
    const starContainer = document.getElementById('starRatingContainer');
    const ratingInput = document.getElementById('reviewRating');

    // Cek di console (F12) kalau tombolnya tidak ketemu
    if (!writeBtn) {
        console.error("Tombol writeReviewBtn tidak ditemukan di HTML!");
        return;
    }

    // FUNGSI BUKA
    writeBtn.onclick = function() {
        console.log("Tombol diklik, membuka modal...");
        modalOverlay.style.display = 'flex'; // Paksa display flex agar di tengah
        modalOverlay.classList.add('open'); 
        document.body.style.overflow = 'hidden'; 
    };

    // FUNGSI TUTUP
    if (closeBtn) {
        closeBtn.onclick = function() {
            modalOverlay.style.display = 'none';
            modalOverlay.classList.remove('open');
            document.body.style.overflow = '';
            resetStars();
        };
    }

    // Klik di luar kotak modal untuk tutup
    window.onclick = function(event) {
        if (event.target == modalOverlay) {
            modalOverlay.style.display = 'none';
            modalOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }
    };

    // Logika Bintang (Tetap Smooth)
    if (starContainer) {
        const stars = starContainer.querySelectorAll('i');
        stars.forEach(star => {
            star.addEventListener('mouseenter', function() { updateStarUI(this.dataset.value, 'hover'); });
            star.addEventListener('click', function() { 
                ratingInput.value = this.dataset.value; 
                updateStarUI(this.dataset.value, 'active'); 
            });
        });
        starContainer.addEventListener('mouseleave', () => { updateStarUI(ratingInput.value, 'active'); });
    }

    function updateStarUI(val, className) {
        const stars = starContainer.querySelectorAll('i');
        stars.forEach(s => {
            s.classList.remove('hover', 'active', 'fas');
            s.classList.add('far');
            if (s.dataset.value <= val) { 
                s.classList.add(className, 'fas'); 
                s.classList.remove('far'); 
            }
        });
    }

    function resetStars() {
        if(ratingInput) ratingInput.value = '0';
        updateStarUI(0, 'active');
        const form = document.getElementById('reviewForm');
        if(form) form.reset();
    }
}

// Tambahkan di dalam file script.js
function setupLoginModal() {
    const loginModal = document.getElementById('loginModal');
    const loginBtn = document.getElementById('loginBtn');
    const closeLogin = document.getElementById('closeLoginModal');
    
    // Elemen Toggle
    const loginContent = document.getElementById('loginContent');
    const signupContent = document.getElementById('signupContent');
    const toSignup = document.getElementById('toSignup');
    const toLogin = document.getElementById('toLogin');

    // LOGIKA PINDAH KE SIGNUP
    if (toSignup) {
        toSignup.onclick = function() {
            loginContent.style.display = 'none';
            signupContent.style.display = 'block';
        };
    }

    // LOGIKA PINDAH KE LOGIN
    if (toLogin) {
        toLogin.onclick = function() {
            signupContent.style.display = 'none';
            loginContent.style.display = 'block';
        };
    }

    // FUNGSI BUKA (Selalu tampilkan Login dulu saat dibuka)
    loginBtn.onclick = function(e) {
        e.preventDefault();
        loginModal.style.setProperty('display', 'flex', 'important');
        loginContent.style.display = 'block';
        signupContent.style.display = 'none';
        document.body.style.overflow = 'hidden';
    };

    // FUNGSI TUTUP
    closeLogin.onclick = function() {
        loginModal.style.display = 'none';
        document.body.style.overflow = '';
    };

    window.onclick = function(event) {
        if (event.target == loginModal) {
            loginModal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };
}

/* ==========================================
   3. JALANKAN SEMUA
   ========================================== */
window.onload = function() {
    setupBanner();
    setupFavorites();
    switchReviewTab('terbaru');
    setupModalAndStars(); // Untuk Form Review
    setupLoginModal();    // UNTUK FORM LOGIN BARU
};