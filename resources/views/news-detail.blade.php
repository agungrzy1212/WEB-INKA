@extends('layouts.app')

@section('title', $article->title)

@section('content')

    <!-- MAIN BODY -->
    <section class="section-wrapper" style="margin-top: 40px; max-width: 800px;">
        
        <a href="{{ route('news') }}" style="display: inline-flex; align-items: center; gap: 8px; color: var(--color-blue-primary); font-weight: 700; margin-bottom: 25px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita
        </a>

        <article class="glass-card" style="background: white; padding: 40px;">
            
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                <span><i class="fa-regular fa-calendar-days"></i> {{ $article->created_at->translatedFormat('d F Y') }}</span>
                <span>|</span>
                <span><i class="fa-solid fa-user-pen"></i> Ditulis oleh Admin LKP INKA</span>
            </div>

            <h1 style="font-size: 2.2rem; font-weight: 800; color: var(--color-blue-dark); line-height: 1.3; margin-bottom: 30px;">
                {{ $article->title }}
            </h1>

            @if($article->image_path)
                <div style="width: 100%; height: 350px; border-radius: var(--radius-md); overflow: hidden; margin-bottom: 35px; border: 1px solid #cbd5e1;">
                    <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            @endif

            <div style="font-size: 1.05rem; line-height: 1.8; color: var(--text-primary); text-align: justify; white-space: pre-line;">
                {{ $article->content }}
            </div>
            
        </article>
        
    </section>

@endsection
