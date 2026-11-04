@extends('layouts.app')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')

    <div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(30, 41, 59, 0.78) 100%), url('{{ asset('img/bg-login.jpg') }}') no-repeat center center; background-size: cover; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
        
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 480px; margin: 0;">
            
            <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
                <div style="width: 60px; height: 60px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 15px auto;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 style="font-size: 1.7rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 8px;">Kata Sandi <span>Baru</span></h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.5;">
                    Silakan tentukan kata sandi baru untuk mengamankan akun Anda.
                </p>
            </div>
            
            <form action="{{ route('password.update') }}" method="POST" id="resetForm">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="email" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--color-blue-dark); font-size: 0.9rem;">
                        Alamat Email <span style="color: var(--color-red);">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="contoh: budi@gmail.com" required value="{{ old('email', $email ?? '') }}" style="padding-left: 42px;">
                    </div>
                    @error('email')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="password" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--color-blue-dark); font-size: 0.9rem;">
                        Kata Sandi Baru <span style="color: var(--color-red);">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem;">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter..." required style="padding-left: 42px;">
                    </div>
                    @error('password')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="password_confirmation" style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--color-blue-dark); font-size: 0.9rem;">
                        Konfirmasi Kata Sandi Baru <span style="color: var(--color-red);">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem;">
                            <i class="fa-solid fa-circle-check"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru..." required style="padding-left: 42px;">
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; padding: 12px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Kata Sandi Baru
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.06); font-size: 0.88rem; font-weight: 600;">
                <a href="{{ route('login') }}" style="color: var(--color-blue-primary); text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Masuk
                </a>
            </div>

        </div>
        
    </div>

@endsection

@section('scripts')
<script>
    document.getElementById('resetForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan Perubahan...';
    });
</script>
@endsection
