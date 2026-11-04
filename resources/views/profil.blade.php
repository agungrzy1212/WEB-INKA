@extends('layouts.app')

@section('title', 'Tentang Kami & Profil Lembaga')

@section('content')

    <!-- PROFIL HERO -->
    <section class="hero-section" style="padding: 60px 20px; background: linear-gradient(135deg, rgba(29, 78, 216, 0.08) 0%, rgba(245, 158, 11, 0.05) 50%, rgba(239, 68, 68, 0.05) 100%);">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 10px;">
                Profil <span>LKP INKA</span> Wonosobo
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">Mengenal Lebih Dekat Lembaga Pelatihan Keterampilan Kerja Terpercaya di Wonosobo</p>
        </div>
    </section>

    <!-- CONTENT BODY -->
    <section class="section-wrapper">
        <div class="profil-section">
            <div class="profil-about">
                <h3>Mencetak Sumber Daya Manusia Unggul & Siap Kerja</h3>
                <p>{!! nl2br(e($about)) !!}</p>
                
                <div style="background: white; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-premium); border-left: 5px solid var(--color-blue-primary); margin-top: 30px;">
                    <h5 style="font-weight: 800; font-size: 1.1rem; color: var(--color-blue-dark); margin-bottom: 10px;">Sejarah Singkat</h5>
                    <p style="font-size: 0.92rem; color: var(--text-muted); line-height: 1.7; text-align: justify; margin-bottom: 0;">
                        {!! nl2br(e($sejarah)) !!}
                    </p>
                </div>
            </div>
            
            <div class="profil-vision-misi">
                <div class="vision-box">
                    <h4><i class="fa-solid fa-eye"></i> VISI</h4>
                    <p style="color: var(--text-muted); text-align: justify; line-height: 1.7; font-weight: 500;">
                        Terwujudnya Lembaga Pendidikan keterampilan Kompetensi yang mamapu memfasilitasi layanan pendidikan berkualitas berbasis Iman dan Taqwa, Ilmu Pengetahuan dan Teknologi (IMTAQ & IPTEK) sesuai kebutuhan masyarakat serta berazas Pancasila dan UUD 45.
                    </p>
                </div>
                
                <div class="misi-box">
                    <h4><i class="fa-solid fa-bullseye"></i> MISI</h4>
                    <ul style="list-style: none;">
                        <li>Memberikan bekal keterampilan berbasisi kompetensi yang siap bersaing memnuhi bursa kerja Lokal, Nasional & Internasional.</li>
                        <li>Meningkatkan kualitas Lembaga, Pendidik, Tenaga Pendidik dan Tenaga Kependidikan.</li>
                        <li>Membangkitkan semangat belajar masyarakat untuk meningkatkan kualitas Sumber daya Manusia (SDM) melalui pendidikan keterampilan hidup (Life Skill) Yang kompeten.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- KEGIATAN KURSUS MARQUEE -->
        <div class="kegiatan-carousel-section" style="margin-top: 80px; margin-bottom: 80px; overflow: hidden; position: relative;">
            <div class="section-header" style="margin-bottom: 40px;">
                <h2>Galeri <span>Kegiatan Kursus</span></h2>
                <p>Dokumentasi aktivitas pembelajaran praktikal dan interaktif yang seru di kelas kami.</p>
            </div>
            
            <div class="marquee-container" style="display: flex; gap: 20px; width: max-content; animation: scrollMarquee 25s linear infinite;">
                @if($galleryImages->count() > 0)
                    <!-- Set 1 -->
                    @foreach($galleryImages as $image)
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title ?? 'Kegiatan Kursus' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endforeach
                    
                    <!-- Set 2 (Duplicate for seamless loop) -->
                    @foreach($galleryImages as $image)
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title ?? 'Kegiatan Kursus' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endforeach
                @else
                    <!-- Fallback Set 1 -->
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Komputer" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Mengemudi" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Otomotif" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Kecantikan" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1555529771-835f59bfc50c?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Menjahit" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    
                    <!-- Fallback Set 2 -->
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Komputer" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Mengemudi" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1589939705384-5185137a7f0f?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Otomotif" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Kecantikan" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="kegiatan-card" style="width: 320px; height: 220px; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); flex-shrink: 0;">
                        <img src="https://images.unsplash.com/photo-1555529771-835f59bfc50c?auto=format&fit=crop&q=80&w=400&h=300" alt="Kegiatan Menjahit" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endif
            </div>
            
            <!-- Left and Right Gradient Fades for seamless transition effect -->
            <div style="position: absolute; top: 0; bottom: 0; left: 0; width: 120px; background: linear-gradient(to right, #f8fafc, transparent); pointer-events: none; z-index: 2;"></div>
            <div style="position: absolute; top: 0; bottom: 0; right: 0; width: 120px; background: linear-gradient(to left, #f8fafc, transparent); pointer-events: none; z-index: 2;"></div>
        </div>

        <!-- GALLERY FACILITIES -->
        <div class="profil-gallery">
            <div class="section-header" style="margin-bottom: 40px;">
                <h2>Fasilitas <span>Pembelajaran Kami</span></h2>
                <p>Kami menyediakan fasilitas ruang kelas, bengkel laboratorium, dan sarana praktik modern guna memastikan proses belajar berjalan maksimal.</p>
            </div>
            
            <div class="gallery-grid">
                <div class="gallery-item">
                    <i class="fa-solid fa-laptop-code"></i>
                    <div class="gallery-overlay">
                        <div style="text-align: center; padding: 15px;">
                            <h5 style="font-weight: 800; font-size: 1rem; margin-bottom: 5px;">Laboratorium Komputer</h5>
                            <p style="font-size: 0.75rem;">Fasilitas PC modern high-end terintegrasi dengan akses internet berkecepatan tinggi.</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(240, 99, 17, 0.1) 100%);">
                    <i class="fa-solid fa-car-side" style="color: var(--color-yellow);"></i>
                    <div class="gallery-overlay" style="background: rgba(245, 158, 11, 0.8);">
                        <div style="text-align: center; padding: 15px;">
                            <h5 style="font-weight: 800; font-size: 1rem; margin-bottom: 5px;">Armada Mengemudi</h5>
                            <p style="font-size: 0.75rem;">Kendaraan latih manual & matic bersertifikat dengan double pedal pengaman instruktur.</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%);">
                    <i class="fa-solid fa-wrench" style="color: var(--color-red);"></i>
                    <div class="gallery-overlay" style="background: rgba(239, 68, 68, 0.8);">
                        <div style="text-align: center; padding: 15px;">
                            <h5 style="font-weight: 800; font-size: 1rem; margin-bottom: 5px;">Bengkel Praktikum</h5>
                            <p style="font-size: 0.75rem;">Sarana praktik mesin otomotif mobil & motor lengkap beserta simulator diagnosa kelistrikan.</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(37, 99, 235, 0.1) 100%);">
                    <i class="fa-solid fa-scissors" style="color: var(--color-blue-light);"></i>
                    <div class="gallery-overlay">
                        <div style="text-align: center; padding: 15px;">
                            <h5 style="font-weight: 800; font-size: 1rem; margin-bottom: 5px;">Studio MUA & Salon</h5>
                            <p style="font-size: 0.75rem;">Fasilitas studio tata rias pengantin lengkap dengan kosmetik premium dan peralatan kecantikan wajah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOCATION MAP -->
        <div style="margin-top: 80px;">
            <div class="section-header" style="margin-bottom: 40px;">
                <h2>Lokasi <span>Kampus Utama</span></h2>
                <p>Kami terletak strategis di pusat kota Wonosobo, memudahkan akses transportasi calon siswa dari berbagai penjuru.</p>
            </div>
            
            <div class="glass-card" style="padding: 10px; overflow: hidden; height: 350px; position: relative;">
                <!-- Link overlay to open Google Maps directly when clicked -->
                <a href="https://www.google.com/maps/search/?api=1&query=LKP+INKA+Wonosobo" target="_blank" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; display: block;" title="Buka di Google Maps"></a>
                <!-- Google Maps iframe -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.8675588616925!2d109.89680507500076!3d-7.368738492640536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7aa0ffb0bc201b%3A0x267bc09f4653242e!2sLKP%20INKA!5e0!3m2!1sid!2sid!4v1784463201701!5m2!1sid!2sid" width="100%" height="100%" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
    </section>

    <style>
        @keyframes floatMarker {
            0%, 100% { transform: translateY(0) rotate(-45deg); }
            50% { transform: translateY(-8px) rotate(-45deg); }
        }
        @keyframes scrollMarquee {
            0% { transform: translateX(0); }
            /* We shift by half the total width of the container minus half a gap to perfectly align the loop */
            100% { transform: translateX(calc(-50% - 10px)); }
        }
        /* Pause animation on hover */
        .marquee-container:hover {
            animation-play-state: paused !important;
        }
    </style>

@endsection
