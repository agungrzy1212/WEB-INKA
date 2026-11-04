@extends('layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')

    <div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(30, 41, 59, 0.78) 100%), url('{{ asset('img/bg-login.jpg') }}') no-repeat center center; background-size: cover; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
        
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 450px; margin: 0;">
            
            <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
                <h3 style="font-size: 1.8rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 5px;">Masuk <span>Sistem</span></h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Akses Dasbor Pendaftaran LKP INKA Wonosobo</p>
            </div>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="email">Alamat Email <span>*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="contoh: budi@gmail.com" required value="{{ old('email') }}">
                    @error('email')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi <span>*</span></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi..." required>
                    @error('password')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; font-size: 0.85rem; font-weight: 600;">
                    <label style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); cursor: pointer;">
                        <input type="checkbox" name="remember" style="accent-color: var(--color-blue-primary);"> Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" style="color: var(--color-blue-primary); text-decoration: none; font-weight: 600; transition: all 0.2s ease;">Lupa Sandi?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Sekarang
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 25px; font-size: 0.9rem; color: var(--text-muted); font-weight: 600;">
                Belum memiliki akun? <a href="{{ route('register') }}" style="color: var(--color-blue-primary); text-decoration: underline;">Daftar Akun Baru</a>
            </div>



        </div>
        
    </div>

@endsection

@section('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Pause submission to show progress
        
        const form = this;
        const btn = form.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        }
        
        // Fullscreen dynamic gradient backdrop
        const loader = document.createElement('div');
        loader.style.position = 'fixed';
        loader.style.inset = '0';
        loader.style.background = 'rgba(255, 255, 255, 0.2)';
        loader.style.backdropFilter = 'blur(8px)';
        loader.style.zIndex = '9999';
        loader.style.display = 'flex';
        loader.style.alignItems = 'center';
        loader.style.justifyContent = 'center';
        loader.style.opacity = '0';
        loader.style.transition = 'opacity 0.4s ease';
        
        // CSS rules injected dynamically
        const style = document.createElement('style');
        style.innerHTML = `
            @keyframes spinRing {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            @keyframes pulseGlass {
                0%, 100% { 
                    transform: scale(1);
                }
                50% { 
                    transform: scale(1.02);
                }
            }
        `;
        document.head.appendChild(style);
        
        loader.innerHTML = `
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(59, 130, 246, 0.1); filter: blur(50px); border-radius: 50%; z-index: -1; animation: pulseGlass 4s infinite reverse;"></div>
            <div style="background: rgba(255, 255, 255, 0.45); border: 2px solid rgba(255, 255, 255, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); padding: 50px 40px; text-align: center; color: #1e293b; width: 90%; max-width: 380px; border-radius: 24px; box-shadow: inset 0 0 20px rgba(255,255,255,0.5), inset 10px 0 40px rgba(255,255,255,0.4), inset -10px 0 40px rgba(255,255,255,0.4), 0 20px 40px -10px rgba(0,0,0,0.1); animation: pulseGlass 1s ease-in-out infinite;">
                <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 25px auto; display: flex; align-items: center; justify-content: center;">
                    <!-- Outer Glowing Orbit Ring -->
                    <div style="position: absolute; inset: 0; border: 3px solid transparent; border-top-color: #3b82f6; border-bottom-color: #93c5fd; border-radius: 50%; animation: spinRing 1.5s linear infinite; box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);"></div>
                    <!-- Inner Icon -->
                    <div id="loadIcon" style="font-size: 2.2rem; color: #3b82f6; display: flex; align-items: center; justify-content: center; filter: drop-shadow(0 4px 6px rgba(59,130,246,0.3));"><i class="fa-solid fa-shield-halved"></i></div>
                </div>
                
                <h4 id="loadTitle" style="font-weight: 800; letter-spacing: 0.5px; margin-bottom: 8px; font-family: 'Plus Jakarta Sans', sans-serif;">Menyiapkan Akun</h4>
                <p id="loadStatus" style="font-size: 0.85rem; color: #64748b; font-family: 'Plus Jakarta Sans', sans-serif; min-height: 20px; transition: all 0.2s ease;">Menghubungkan ke server...</p>
            </div>
        `;
        
        document.body.appendChild(loader);
        
        // Force reflow and fade in
        setTimeout(() => {
            loader.style.opacity = '1';
        }, 10);
        
        // Progress tick animation
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.floor(Math.random() * 1) + 1; // random step increment
            if (progress > 100) progress = 100;
            
            const statusText = document.getElementById('loadStatus');
            if (progress < 30) {
                statusText.innerText = 'Memvalidasi kredensial...';
            } else if (progress < 60) {
                statusText.innerText = 'Menginisialisasi modul dasbor...';
            } else if (progress < 85) {
                statusText.innerText = 'Mengunduh pengaturan sesi...';
            } else if (progress < 100) {
                statusText.innerText = 'Otentikasi berhasil!';
            } else {
                statusText.innerText = 'Membuka Dasbor...';
            }
            
            if (progress >= 100) {
                clearInterval(interval);
                
                // Show final success state
                document.getElementById('loadIcon').innerHTML = '<i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 2.5rem; filter: drop-shadow(0 0 8px rgba(16,185,129,0.5));"></i>';
                statusText.style.color = '#10b981';
                statusText.style.fontWeight = 'bold';
                
                // Submit form after showing 100% checkmark briefly
                setTimeout(() => {
                    form.submit();
                }, 300);
            }
        }, 50); // total duration ~2s
    });
</script>
@endsection
