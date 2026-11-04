@extends('layouts.app')

@section('title', 'Lembaga Kursus Keterampilan Terakreditasi')

@section('content')

    <!-- HERO BANNER -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1>{!! str_replace('LKP INKA', '<span>LKP INKA</span>', e($heroTitle)) !!}</h1>
                <p>{{ $heroSubtitle }}</p>
                <div style="display: flex; gap: 15px;">
                    <a href="{{ route('pendaftaran') }}" class="btn btn-primary">
                        <i class="fa-solid fa-file-signature"></i> {{ $ctaText }}
                    </a>
                    <a href="{{ route('kursus') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-list"></i> Lihat Pilihan Kursus
                    </a>
                </div>
            </div>
            
            <div class="hero-image-box">
                <div class="hero-image-card">
                    <img src="{{ asset('img/bg-login.jpg') }}" alt="Belajar Komputer LKP INKA" style="width: 100%; max-width: 450px; height: 280px; object-fit: cover; border-radius: 12px; display: block; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                    <div class="hero-decor-badge hero-badge-1">
                        <i class="fa-solid fa-circle-check" style="color: var(--color-blue-light); font-size: 1.2rem;"></i>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Status Lembaga</div>
                            <div style="font-size: 0.95rem;">Terakreditasi BAN</div>
                        </div>
                    </div>
                    
                    <div class="hero-decor-badge hero-badge-2">
                        <i class="fa-solid fa-users" style="color: var(--color-yellow); font-size: 1.2rem;"></i>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Jumlah Lulusan</div>
                            <div style="font-size: 0.95rem;">12.000+ Alumni</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BAR -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-num">12.000+</div>
            <div class="stat-label">Alumni Sukses</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">24</div>
            <div class="stat-label">Pilihan Kursus</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">18+</div>
            <div class="stat-label">Instruktur Ahli</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">95%</div>
            <div class="stat-label">Penyaluran Kerja/Wirausaha</div>
        </div>
    </div>

    <!-- ALUR PENDAFTARAN -->
    <section class="section-wrapper">
        <div class="section-header">
            <h2>Alur Pendaftaran <span>Kursus Online</span></h2>
            <p>Proses pendaftaran di LKP INKA Wonosobo sangat mudah, praktis, dan dapat diakses dari mana saja.</p>
        </div>
        
        <div class="alur-grid">
            <div class="alur-card">
                <div class="alur-num">1</div>
                <i class="fa-solid fa-user-plus alur-icon"></i>
                <h3>Daftar Akun</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Buat akun calon peserta kursus menggunakan alamat email aktif Anda.</p>
            </div>
            
            <div class="alur-card">
                <div class="alur-num">2</div>
                <i class="fa-solid fa-file-invoice alur-icon" style="color: var(--color-yellow);"></i>
                <h3>Isi Formulir</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Pilih salah satu dari 24 pilihan kursus dan isi data pendaftaran diri lengkap.</p>
            </div>
            
            <div class="alur-card">
                <div class="alur-num">3</div>
                <i class="fa-solid fa-cloud-arrow-up alur-icon" style="color: var(--color-red);"></i>
                <h3>Unggah Berkas</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Unggah dokumen syarat pendaftaran asli dan lakukan pembayaran biaya administrasi via QRIS.</p>
            </div>
            
            <div class="alur-card">
                <div class="alur-num">4</div>
                <i class="fa-solid fa-id-card alur-icon" style="color: var(--color-blue-light);"></i>
                <h3>Cetak Bukti</h3>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Setelah data dikirim, cetak kartu bukti pendaftaran ber-QR Code untuk mulai kursus.</p>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="section-wrapper" style="background: rgba(29, 78, 216, 0.03); padding: 50px 20px; border-radius: var(--radius-lg);">
        <div class="section-header">
            <h2>Apa Kata <span>Alumni Kami</span>?</h2>
            <p>Dengarkan kisah sukses langsung dari mereka yang telah berhasil merintis karir profesional dan bisnis mandiri setelah lulus pelatihan.</p>
        </div>
        
        <div class="news-grid">
            <div class="glass-card" style="text-align: center; background: white;">
                <div class="profile-avatar" style="margin: 0 auto 20px auto; width: 60px; height: 60px;">R</div>
                <h4 style="font-weight: 700;">Rizqi Amalia</h4>
                <p style="font-size: 0.75rem; color: var(--color-blue-primary); font-weight: 600; margin-bottom: 15px;">Alumni Desain Grafis — Pemilik Studio Kreatif</p>
                <p style="font-style: italic; font-size: 0.9rem; color: var(--text-muted);">"Materi kursus LKP INKA sangat aplikatif! Instruktur sangat sabar mengajari dari nol sampai mahir. Kini saya bisa mendirikan usaha studio jasa desain saya sendiri di Wonosobo."</p>
            </div>

            <div class="glass-card" style="text-align: center; background: white;">
                <div class="profile-avatar" style="margin: 0 auto 20px auto; width: 60px; height: 60px; background: var(--grad-yellow);">A</div>
                <h4 style="font-weight: 700;">Ahmad Fauzi</h4>
                <p style="font-size: 0.75rem; color: var(--color-yellow); font-weight: 600; margin-bottom: 15px;">Alumni Mekanik Motor — Wirausaha Bengkel Mandiri</p>
                <p style="font-style: italic; font-size: 0.9rem; color: var(--text-muted);">"Dua bulan kursus di kelas bengkel motor LKP INKA, saya langsung dibekali alat praktikum lengkap. Lulus dari sini, saya langsung dibantu bimbingan bisnis untuk mendirikan bengkel motor sendiri."</p>
            </div>

            <div class="glass-card" style="text-align: center; background: white;">
                <div class="profile-avatar" style="margin: 0 auto 20px auto; width: 60px; height: 60px; background: var(--grad-red);">N</div>
                <h4 style="font-weight: 700;">Nabila Safitri</h4>
                <p style="font-size: 0.75rem; color: var(--color-red); font-weight: 600; margin-bottom: 15px;">Alumni Tata Rias Pengantin — MUA Profesional</p>
                <p style="font-style: italic; font-size: 0.9rem; color: var(--text-muted);">"Program MUA LKP INKA sangat berkualitas. Kami belajar berbagai teknik rias adat dan modern langsung praktik dengan model. Sangat direkomendasikan bagi yang ingin sukses mandiri!"</p>
            </div>
        </div>
    </section>

    <!-- LATEST NEWS PREVIEW -->
    @if($news->isNotEmpty())
        <section class="section-wrapper">
            <div class="section-header">
                <h2>Berita & <span>Informasi Terbaru</span></h2>
                <p>Ikuti perkembangan terbaru mengenai program pelatihan gratis subsidi pemerintah, jadwal ujian, dan info alumni.</p>
            </div>
            
            <div class="news-grid">
                @foreach($news as $item)
                    <div class="news-card">
                        <div class="news-image">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div class="news-body">
                            <div class="news-date">{{ $item->created_at->translatedFormat('d F Y') }}</div>
                            <h3>{{ $item->title }}</h3>
                            <p>{{ Str::limit($item->content, 120) }}</p>
                            <a href="{{ route('news.detail', $item->id) }}" class="news-link">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div style="text-align: center; margin-top: 40px;">
                <a href="{{ route('news') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-globe"></i> Lihat Semua Berita
                </a>
            </div>
        </section>
    @endif

@endsection
