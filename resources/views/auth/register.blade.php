@extends('layouts.app')

@section('title', 'Daftar Akun Calon Siswa Baru')

@section('content')

    <div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(30, 41, 59, 0.78) 100%), url('{{ asset('img/bg-login.jpg') }}') no-repeat center center; background-size: cover; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
        
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 450px; margin: 0;">
            
            <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
                <h3 style="font-size: 1.8rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 5px;">Registrasi <span>Akun</span></h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Buat Akun Calon Peserta Kursus LKP INKA Wonosobo</p>
            </div>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nama Lengkap Anda <span>*</span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="contoh: Budi Santoso" required value="{{ old('name') }}">
                    @error('name')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email Aktif <span>*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="contoh: budi@gmail.com" required value="{{ old('email') }}">
                    @error('email')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi Baru <span>*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter..." required>
                    @error('password')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi <span>*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru..." required>
                </div>

                <div style="margin-bottom: 25px; font-size: 0.82rem; color: var(--text-muted); font-weight: 600; line-height: 1.5;">
                    Dengan mendaftar, Anda menyetujui seluruh <span style="color: var(--color-blue-primary); cursor: pointer;">Syarat & Ketentuan Layanan</span> LKP INKA Wonosobo.
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fa-solid fa-user-plus"></i> Buat Akun Baru
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">
                Sudah memiliki akun? <a href="{{ route('login') }}" style="color: var(--color-blue-primary); text-decoration: underline;">Masuk Sekarang</a>
            </div>

        </div>
        
    </div>

@endsection
