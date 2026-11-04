@extends('layouts.app')

@section('title', 'Lupa Kata Sandi')

@section('content')

    <div style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.88) 0%, rgba(30, 41, 59, 0.78) 100%), url('{{ asset('img/bg-login.jpg') }}') no-repeat center center; background-size: cover; min-height: 85vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px;">
        
        <div class="glass-card" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); border-radius: var(--radius-lg); padding: 40px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2); width: 100%; max-width: 480px; margin: 0;">
            
            <div class="auth-header" style="text-align: center; margin-bottom: 25px;">
                <div style="width: 60px; height: 60px; background: rgba(29, 78, 216, 0.1); color: var(--color-blue-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 15px auto;">
                    <i class="fa-solid fa-key"></i>
                </div>
                <h3 style="font-size: 1.7rem; font-weight: 800; color: var(--color-blue-dark); margin-bottom: 8px;">Lupa <span>Kata Sandi?</span></h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.5;">
                    Masukkan alamat email yang terdaftar pada akun Anda. Kami akan mengirimkan instruksi untuk menyetel ulang kata sandi.
                </p>
            </div>

            @if (session('status'))
                <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 14px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 0.88rem; display: flex; align-items: flex-start; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="color: #10b981; font-size: 1.2rem; margin-top: 2px;"></i>
                    <div>
                        <strong>Permintaan Berhasil!</strong>
                        <div style="margin-top: 2px;">{{ session('status') }}</div>
                    </div>
                </div>
            @endif

            @if (session('dev_reset_url'))
                <div style="background: #eff6ff; border: 1px dashed #3b82f6; color: #1e40af; padding: 14px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-size: 0.85rem;">
                    <div style="font-weight: 700; display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                        <i class="fa-solid fa-vial"></i> Mode Pengujian (Email Driver Log)
                    </div>
                    <p style="margin-bottom: 10px; color: #334155; line-height: 1.4;">
                        Tautan reset berhasil dibuat. Anda dapat langsung mengklik tombol di bawah ini untuk mencoba reset sandi:
                    </p>
                    <a href="{{ session('dev_reset_url') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; width: 100%; justify-content: center; text-decoration: none;">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Formulir Reset Kata Sandi
                    </a>
                </div>
            @endif
            
            <form action="{{ route('password.email') }}" method="POST" id="forgotForm">
                @csrf
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="email" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--color-blue-dark); font-size: 0.9rem;">
                        Alamat Email Terdaftar <span style="color: var(--color-red);">*</span>
                    </label>
                    <div style="position: relative;">
                        <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 1rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control" placeholder="contoh: budi@gmail.com" required value="{{ old('email') }}" style="padding-left: 42px;">
                    </div>
                    @error('email')
                        <span style="font-size: 0.8rem; color: var(--color-red); font-weight: 600; margin-top: 6px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary" style="width: 100%; padding: 12px; font-weight: 600; font-size: 0.95rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Tautan Reset Sandi
                </button>
            </form>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px; padding-top: 20px; border-top: 1px solid rgba(0,0,0,0.06); font-size: 0.88rem; font-weight: 600;">
                <a href="{{ route('login') }}" style="color: var(--text-muted); display: flex; align-items: center; gap: 6px; text-decoration: none; transition: color 0.2s;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Masuk
                </a>
                <a href="{{ route('register') }}" style="color: var(--color-blue-primary); text-decoration: none;">
                    Daftar Akun Baru
                </a>
            </div>

            <!-- Bantuan Kontak Admin via WhatsApp -->
            <div style="margin-top: 20px; padding: 14px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid #e2e8f0; text-align: center;">
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 8px;">
                    Lupa email Anda atau butuh bantuan lebih lanjut?
                </p>
                <a href="https://wa.me/6282324876436?text=Halo%20Admin%20LKP%20INKA,%20saya%20mengalami%20kendala%20lupa%20kata%20sandi%20akun%20saya.%20Mohon%20bantuannya." target="_blank" style="display: inline-flex; align-items: center; gap: 8px; color: #16a34a; font-weight: 700; font-size: 0.85rem; text-decoration: none;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i> Hubungi Layanan Admin WhatsApp
                </a>
            </div>

        </div>
        
    </div>

@endsection

@section('scripts')
<script>
    document.getElementById('forgotForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim Instruksi...';
    });
</script>
@endsection
