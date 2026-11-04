@extends('layouts.app')

@section('title', 'Kabar, Portal Berita & Pengumuman Terbaru')

@section('content')

    <!-- HERO HEADER -->
    <section class="hero-section" style="padding: 60px 20px; background: linear-gradient(135deg, rgba(29, 78, 216, 0.08) 0%, rgba(245, 158, 11, 0.05) 50%, rgba(239, 68, 68, 0.05) 100%);">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 2.5rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 10px;">
                Berita & <span>Informasi</span> Terbaru
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem;">
                Ikuti Pengumuman, Agenda Pelatihan Keterampilan, dan Kisah Sukses Alumni LKP INKA Wonosobo
            </p>
        </div>
    </section>

    <!-- CONTENT BODY -->
    <section class="section-wrapper" style="margin-top: 40px;">
        
        <div class="news-grid">
            @forelse($news as $item)
                <div class="news-card">
                    <div class="news-image">
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-newspaper"></i>
                        @endif
                    </div>
                    <div class="news-body">
                        <div class="news-date">
                            <i class="fa-regular fa-calendar-days"></i> {{ $item->created_at->translatedFormat('d F Y') }}
                        </div>
                        <h3>{{ $item->title }}</h3>
                        <p>{{ Str::limit($item->content, 140) }}</p>
                        <a href="{{ route('news.detail', $item->id) }}" class="news-link">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 50px; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-premium);">
                    <i class="fa-solid fa-inbox" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 15px;"></i>
                    <h4 style="font-weight: 700;">Belum ada berita diterbitkan</h4>
                    <p style="color: var(--text-muted); margin-bottom: 0;">Silakan kembali lagi nanti untuk berita dan update terbaru dari LKP INKA Wonosobo.</p>
                </div>
            @endforelse
        </div>
        
    </section>

@endsection
