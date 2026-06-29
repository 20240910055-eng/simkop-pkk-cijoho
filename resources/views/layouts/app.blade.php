<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMKOP PKK Cijoho</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        }
        .custom-navbar {
            background-color: #0d6efd;
        }
        .navbar-brand { 
            font-weight: 700; 
            font-size: 1.15rem;
        }

        /* KUSTOMISASI LACI MENU */
        .custom-offcanvas {
            background-color: #5c83f0 !important; /* Warna biru soft */
            border-top-left-radius: 25px; /* Kelengkungan atas kiri */
            border-bottom-left-radius: 25px; /* Kelengkungan bawah kiri */
            border-left: none;
            width: 280px !important;
        }

        /* Judul Kategori Menu (BERANDA, TRANSAKSI, dll) */
        .menu-category {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 20px;
            margin-bottom: 8px;
            padding-left: 10px;
            text-transform: uppercase;
        }

        /* Tombol Link Menu */
        .menu-link {
            display: flex;
            align-items: center;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 10px 15px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        /* Efek saat Disentuh (Hover) atau Aktif */
        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            padding-left: 20px;
        }

        .menu-link i, .menu-link span.icon {
            margin-right: 12px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

    <!-- Header Navbar Atas -->
    <nav class="navbar navbar-dark custom-navbar shadow-sm py-2.5">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-white" href="{{ url('/') }}">
                🌸 <span class="ms-2">SIMKOP PKK CIJOHO</span>
            </a>
            
            <!-- Tombol Hamburger (Memicu Laci Samping) -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenuSamping">
                <span class="navbar-toggler-icon" style="width: 1.3rem; height: 1.3rem;"></span>
            </button>
        </div>
    </nav>

    <!-- ≡ LACI MENU OFF-CANVAS (SLIDE DARI KANAN) -->
    <div class="offcanvas offcanvas-end text-white custom-offcanvas p-3" tabindex="-1" id="offcanvasMenuSamping" aria-labelledby="offcanvasMenuSampingLabel">
        <div class="offcanvas-header justify-content-end p-0 mb-3">
            <!-- Tombol Tutup Laci (Silang Putih) -->
            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body p-0">
            <!-- KATEGORI: BERANDA -->
            <div class="menu-category">Beranda</div>
            <a href="{{ url('/') }}" class="menu-link">
                <span class="icon">🏠</span> Dashboard
            </a>

            <!-- JIKA USER SUDAH LOGIN (ADMIN), MENU INPUT BARU DISEDIAKAN -->
            @auth
                <!-- KATEGORI: DATA MASTER -->
                <div class="menu-category">Data Master</div>
                <a href="{{ url('/anggota') }}" class="menu-link">
                    <span class="icon">👥</span> Informasi Anggota
                </a>

                <!-- KATEGORI: TRANSAKSI -->
                <div class="menu-category">Pembukuan</div>
                <a href="{{ url('/simpanan') }}" class="menu-link">
                    <span class="icon">💰</span> Buku Simpanan
                </a>
                <a href="{{ url('/kredit') }}" class="menu-link">
                    <span class="icon">📖</span> Buku Kredit
                </a>

                <!-- KATEGORI: LAPORAN -->
                <div class="menu-category">Laporan</div>
                <a href="{{ url('/kas') }}" class="menu-link">
                    <span class="icon">💵</span> Kas Utama
                </a>

                <!-- KATEGORI: USER PROFILE & LOGOUT -->
                <div class="menu-category">Autentikasi</div>
                <div class="px-3 py-2 mb-2 text-white-50 small bg-white bg-opacity-10 rounded-3 mx-2">
                    👤 Admin: <strong class="text-white">{{ Auth::user()->name }}</strong>
                </div>
                
                <!-- Form Log Out Mandiri -->
                <form method="POST" action="{{ route('logout') }}" class="mx-2">
                    @csrf
                    <a href="{{ route('logout') }}" class="menu-link text-warning fw-bold bg-danger bg-opacity-10" 
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="icon">🚪</span> Keluar Sistem
                    </a>
                </form>
            @endauth

            <!-- JIKA BELUM LOGIN (PENGUNJUNG UMUM), TAMPILKAN TOMBOL MASUK SYSTEM -->
            @guest
                <div class="menu-category">Akses Sistem</div>
                <div class="p-2">
                    <a href="{{ route('login') }}" class="btn btn-light text-primary fw-bold w-100 py-2 shadow-sm" style="border-radius: 10px;">
                        🔑 Masuk Sebagai Admin
                    </a>
                </div>
            @endguest
        </div>
    </div>

    <!-- Konten Utama Aplikasi -->
    <div class="container my-4">
        @yield('halaman')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>