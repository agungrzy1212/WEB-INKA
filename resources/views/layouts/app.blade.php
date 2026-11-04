<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LKP INKA Wonosobo</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Design CSS System -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('styles')
</head>
<body>

    <!-- NAV BAR HEADER -->
    <header class="header-nav">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 10px;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo LKP INKA" style="height: 42px; width: auto; object-fit: contain;">
                <span>LKP INKA</span>
            </a>
            
            <nav class="nav-links">
                <a href="{{ route('home') }}" class="nav-item {{ Route::is('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('profil') }}" class="nav-item {{ Route::is('profil') ? 'active' : '' }}">Profil</a>
                <a href="{{ route('kursus') }}" class="nav-item {{ Route::is('kursus') ? 'active' : '' }}">Kursus</a>
                <a href="{{ route('news') }}" class="nav-item {{ Route::is('news*') ? 'active' : '' }}">News</a>
            </nav>

            <div class="nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fa-solid fa-table-columns"></i> Dashboard
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="fa-solid fa-user-plus"></i> Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- DYNAMIC MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER SECTION -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-about">
                <h4><span>LKP INKA</span> Wonosobo</h4>
                <p>Lembaga Kursus dan Pelatihan Keterampilan Kerja Terakreditasi BAN. Mencetak alumni kompeten, siap kerja, dan berjiwa wirausaha mandiri sejak tahun 2012.</p>
                <div class="footer-socials">
                    <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="footer-links-col">
                <h5>Program Kursus</h5>
                <ul>
                    <li><a href="{{ route('kursus', ['category' => 'Komputer']) }}">Program Komputer</a></li>
                    <li><a href="{{ route('kursus', ['category' => 'Mengemudi']) }}">Mengemudi Mobil/Motor</a></li>
                    <li><a href="{{ route('kursus', ['category' => 'Otomotif']) }}">Otomotif & Bengkel</a></li>
                    <li><a href="{{ route('kursus', ['category' => 'Bahasa Inggris']) }}">Bahasa Inggris & Asing</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h5>Halaman</h5>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('profil') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('kursus') }}">Pilihan Kursus</a></li>
                    <li><a href="{{ route('news') }}">Berita Terkini</a></li>
                </ul>
            </div>

            <div class="footer-links-col">
                <h5>Hubungi Kami</h5>
                <ul>
                    <li><i class="fa-solid fa-location-dot"></i> Jl. Bhayangkara No. 45 Rt 004 Rw 011, Kel. Wonosobo Barat,  Kec. Wonosobo Kab.Wonosobo, Prov. Jawa Tengah 56311</li>
                    <li><i class="fa-solid fa-phone"></i> Telp. (0286) 321403 / WA. 0823 2487 6436</li>
                    <li><i class="fa-solid fa-envelope"></i> lkp.inka99@gmail.com</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2026 LKP INKA Wonosobo. Hak Cipta Dilindungi Undang-Undang.</p>
            <p>Dikembangkan untuk Sistem Informasi Pendaftaran Online.</p>
        </div>
    </footer>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div class="toast-container" id="toastContainer">
        @if(session('toast_success'))
            <div class="toast toast-success show">
                <i class="fa-solid fa-circle-check toast-icon"></i>
                <div class="toast-message">{{ session('toast_success') }}</div>
            </div>
        @endif
        @if(session('toast_warning'))
            <div class="toast toast-warning show">
                <i class="fa-solid fa-circle-exclamation toast-icon"></i>
                <div class="toast-message">{{ session('toast_warning') }}</div>
            </div>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="toast toast-danger show">
                    <i class="fa-solid fa-circle-xmark toast-icon"></i>
                    <div class="toast-message">{{ $error }}</div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- GLOBAL SCRIPTS -->
    <script>
        // Dismiss toasts automatically after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        toast.remove();
                    }, 500);
                }, 5000);
            });
        });

        // Dynamic Toast function for JS calling
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type} show`;
            
            let icon = 'fa-circle-check';
            if (type === 'danger') icon = 'fa-circle-xmark';
            if (type === 'warning') icon = 'fa-circle-exclamation';

            toast.innerHTML = `
                <i class="fa-solid ${icon} toast-icon"></i>
                <div class="toast-message">${message}</div>
            `;
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 5000);
        }
    </script>
    @yield('scripts')
</body>
</html>
