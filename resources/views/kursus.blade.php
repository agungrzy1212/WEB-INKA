@extends('layouts.app')

@section('title', 'Pilihan Program Kursus Keterampilan')

@section('content')

    <!-- HERO HEADER -->
    <section class="hero-section" style="padding: 60px 20px; background: linear-gradient(135deg, rgba(29, 78, 216, 0.08) 0%, rgba(245, 158, 11, 0.05) 50%, rgba(239, 68, 68, 0.05) 100%);">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 10px;">
                Program Pelatihan <span>Keterampilan</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">
                Pilih Dari {{ count($courses) }} Program Keahlian Terbaik Yang Telah Teruji Mencetak Lulusan Siap Kerja & Wirausaha
            </p>
        </div>
    </section>

    <!-- MAIN BODY -->
    <section class="section-wrapper" style="margin-top: 40px;">
        
        <!-- SEARCH & FILTER BAR -->
        <div class="filter-bar">
            <!-- PHP and JS-based Search Box -->
            <form action="{{ route('kursus') }}" method="GET" class="search-box" id="searchForm">
                <input type="text" name="q" id="searchInput" placeholder="Cari nama program kursus atau keahlian..." value="{{ request('q') }}">
                <i class="fa-solid fa-magnifying-glass"></i>
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>
            
            <div class="category-filters">
                <a href="{{ route('kursus', ['q' => request('q')]) }}" class="filter-btn {{ !request('category') || request('category') == 'all' ? 'active' : '' }}">
                    Semua
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('kursus', ['category' => $cat, 'q' => request('q')]) }}" class="filter-btn {{ request('category') == $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- COURSE GRID -->
        <div class="course-grid" id="courseGrid">
            @forelse($courses as $course)
                @php
                    // Dynamic icon picker based on category/name
                    $icon = 'fa-graduation-cap';
                    if (str_contains(strtolower($course->category), 'komputer')) {
                        $icon = 'fa-laptop-code';
                    } elseif (str_contains(strtolower($course->category), 'mengemudi')) {
                        $icon = 'fa-car-rear';
                    } elseif (str_contains(strtolower($course->category), 'otomotif')) {
                        $icon = 'fa-gears';
                    } elseif (str_contains(strtolower($course->category), 'menjahit') || str_contains(strtolower($course->category), 'bordir')) {
                        $icon = 'fa-scissors';
                    } elseif (str_contains(strtolower($course->category), 'bahasa')) {
                        $icon = 'fa-language';
                    } elseif (str_contains(strtolower($course->category), 'kecantikan')) {
                        $icon = 'fa-sparkles';
                    } elseif (str_contains(strtolower($course->category), 'elektro')) {
                        $icon = 'fa-microchip';
                    } elseif (str_contains(strtolower($course->category), 'spa')) {
                        $icon = 'fa-spa';
                    } elseif (str_contains(strtolower($course->category), 'kerajinan')) {
                        $icon = 'fa-palette';
                    }
                @endphp
                <div class="course-card" data-category="{{ $course->category }}" data-name="{{ strtolower($course->name) }}">
                    <div class="course-header-img">
                        <i class="fa-solid {{ $icon }}"></i>
                        <span class="course-badge">{{ $course->category }}</span>
                    </div>
                    
                    <div class="course-body">
                        <h3>{{ $course->name }}</h3>
                        <p>{{ $course->description }}</p>
                        
                        <div class="course-meta">
                            <div class="course-price">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
                            <div class="course-duration"><i class="fa-regular fa-clock"></i> {{ $course->duration }}</div>
                        </div>
                    </div>
                    
                    <div class="course-footer-action">
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <button class="btn btn-secondary" style="width: 100%; cursor: not-allowed;" disabled>
                                    <i class="fa-solid fa-lock"></i> Fitur Siswa
                                </button>
                            @else
                                <a href="{{ route('pendaftaran', ['course_id' => $course->id]) }}" class="btn btn-primary">
                                    <i class="fa-solid fa-file-signature"></i> Daftar Sekarang
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-yellow" onclick="sessionStorage.setItem('pending_course_id', '{{ $course->id }}');">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i> Login untuk Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 50px; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-premium);">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 15px;"></i>
                    <h4 style="font-weight: 700;">Program tidak ditemukan</h4>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Silakan coba cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>
        
    </section>

@endsection
