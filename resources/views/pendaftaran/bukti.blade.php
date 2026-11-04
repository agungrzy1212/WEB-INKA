@extends('layouts.app')

@section('title', 'Bukti Pendaftaran Sukses')

@section('content')

    <section class="section-wrapper" style="margin-top: 40px; max-width: 650px;">
        
        <div class="success-screen">
            <i class="fa-solid fa-circle-check"></i>
            <h3>Pendaftaran Anda Berhasil Dikirim!</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin-bottom: 25px;">
                Terima kasih, data pendaftaran Anda sedang diproses oleh tim verifikasi LKP INKA Wonosobo. Di bawah ini adalah kartu tanda pendaftaran digital resmi Anda.
            </p>
        </div>

        <!-- DIGITAL REGISTRATION CARD CONTAINER -->
        <div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-premium); overflow: hidden; border: 1px solid #e2e8f0; margin-bottom: 40px;" id="cardWrapper">
            
            <!-- Card itself (HTML representation for premium display) -->
            <div id="registrationCard" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 30px; position: relative; overflow: hidden; border-bottom: 5px solid var(--color-yellow);">
                
                <!-- Background Mesh Glows -->
                <div style="position: absolute; top: -50px; right: -50px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(59, 130, 246, 0.25) 0%, transparent 70%); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -50px; left: -50px; width: 180px; height: 180px; background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, transparent 70%); border-radius: 50%;"></div>

                <!-- Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; position: relative; z-index: 2;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 8px; font-weight: 800; font-size: 1.15rem;">
                            <img id="cardLogo" src="{{ asset('img/logo.png') }}" alt="Logo LKP INKA" style="height: 32px; width: auto; object-fit: contain; background: white; border-radius: 50%; padding: 2px;"> LKP INKA Wonosobo
                        </div>
                        <div style="font-size: 0.65rem; color: #94a3b8; letter-spacing: 1px; font-weight: 600; text-transform: uppercase; margin-top: 3px;">
                            Kartu Bukti Pendaftaran Kursus
                        </div>
                    </div>
                    
                    @if($registration->status === 'approved')
                        <div style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid #10b981; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                            DISETUJUI
                        </div>
                    @elseif($registration->status === 'rejected')
                        <div style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid #ef4444; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                            DITOLAK
                        </div>
                    @else
                        <div style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid #f59e0b; font-size: 0.72rem; font-weight: 800; padding: 4px 10px; border-radius: 20px;">
                            SELESAI DIKIRIM
                        </div>
                    @endif
                </div>

                <!-- Body Details -->
                <div style="display: grid; grid-template-columns: 1fr 110px; gap: 20px; align-items: center; position: relative; z-index: 2;">
                    <div style="display: grid; gap: 15px;">
                        <div>
                            <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Nomor Registrasi</div>
                            <div style="font-weight: 800; font-size: 1.1rem; color: var(--color-yellow-light);" id="cardRegNo">INKA-{{ date('Y') }}-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Nama Lengkap Peserta</div>
                            <div style="font-weight: 700; font-size: 1.05rem;" id="cardName">{{ $registration->nama_lengkap }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Program Kursus Terpilih</div>
                            <div style="font-weight: 700; font-size: 0.92rem; color: #60a5fa;" id="cardCourse">{{ $registration->course->name }}</div>
                        </div>
                    </div>

                    <!-- QR CODE FOR SCANNING VERIFICATION -->
                    <div style="background: white; padding: 8px; border-radius: var(--radius-sm); text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=95x95&data=https://lkpinka.com/verify/{{ $registration->id }}" alt="QR CODE KARTU INKA" style="display: block; width: 94px; height: 94px;">
                        <span style="font-size: 0.55rem; color: var(--color-blue-dark); font-weight: 800; display: block; margin-top: 4px;">Pindai Verifikasi</span>
                    </div>
                </div>

                <!-- Footer details -->
                <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 15px; display: flex; justify-content: space-between; font-size: 0.72rem; color: #94a3b8; position: relative; z-index: 2;">
                    <span>Tanggal Daftar: {{ $registration->created_at->format('d/m/Y H:i') }}</span>
                    <span>Status Verifikasi: 
                        @if($registration->status === 'approved')
                            <strong style="color: #10b981;">Disetujui</strong>
                        @elseif($registration->status === 'rejected')
                            <strong style="color: var(--color-red);">Ditolak (Perlu Perbaikan)</strong>
                        @else
                            <strong style="color: var(--color-yellow-light);">Menunggu Admin</strong>
                        @endif
                    </span>
                </div>

            </div>

            <!-- Card Bottom Actions panel -->
            <div style="padding: 25px 30px; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                <div>
                    <h6 style="font-weight: 800; color: var(--color-blue-dark); font-size: 0.88rem; margin-bottom: 2px;">Butuh Bantuan?</h6>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0;">Hubungi CS LKP INKA Wonosobo jika ada kendala.</p>
                </div>
                
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('dashboard.siswa') }}" class="btn btn-secondary" style="padding: 10px 20px;">
                        <i class="fa-solid fa-table-columns"></i> Ke Dashboard
                    </a>
                    
                    <button class="btn btn-primary" style="padding: 10px 22px;" id="btnDownloadCard" onclick="downloadDigitalCard()">
                        <i class="fa-solid fa-circle-down"></i> Unduh Kartu Tanda Daftar
                    </button>
                </div>
            </div>

        </div>

    </section>

    <!-- Hidden Canvas to generate downloadable image card in JS -->
    <canvas id="cardCanvas" style="display: none;" width="600" height="350"></canvas>

@endsection

@section('scripts')
<script>
    function downloadDigitalCard() {
        const canvas = document.getElementById('cardCanvas');
        const ctx = canvas.getContext('2d');

        // 1. Draw premium background gradient
        const grad = ctx.createLinearGradient(0, 0, 600, 350);
        grad.addColorStop(0, '#0f172a');
        grad.addColorStop(1, '#1e293b');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 600, 350);

        // 2. Draw border line bottom in gold/yellow
        ctx.fillStyle = '#f59e0b';
        ctx.fillRect(0, 345, 600, 5);

        // 3. Draw radial light blobs (simulated background meshes)
        ctx.fillStyle = 'rgba(59, 130, 246, 0.15)';
        ctx.beginPath();
        ctx.arc(520, 60, 100, 0, Math.PI * 2);
        ctx.fill();

        ctx.fillStyle = 'rgba(239, 68, 68, 0.08)';
        ctx.beginPath();
        ctx.arc(80, 280, 100, 0, Math.PI * 2);
        ctx.fill();

        // 4. Draw text details (Logo)
        const logoImg = document.getElementById('cardLogo');
        if (logoImg) {
            // Draw a white circle background for the logo
            ctx.fillStyle = '#ffffff';
            ctx.beginPath();
            ctx.arc(46, 38, 16, 0, Math.PI * 2);
            ctx.fill();
            // Draw the logo image (circular clipped or simply drawn inside the circle)
            ctx.drawImage(logoImg, 30, 22, 32, 32);
            
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 22px "Plus Jakarta Sans", sans-serif';
            ctx.fillText('LKP INKA Wonosobo', 75, 45);
        } else {
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 22px "Plus Jakarta Sans", sans-serif';
            ctx.fillText('🎓 LKP INKA Wonosobo', 30, 45);
        }

        ctx.fillStyle = '#94a3b8';
        ctx.font = '600 11px "Plus Jakarta Sans", sans-serif';
        ctx.fillText('KARTU BUKTI PENDAFTARAN KURSUS', 30, 65);

        // Done badge
        @if($registration->status === 'approved')
            ctx.fillStyle = 'rgba(16, 185, 129, 0.15)';
            ctx.fillRect(440, 25, 130, 28);
            ctx.strokeStyle = '#10b981';
            ctx.lineWidth = 1;
            ctx.strokeRect(440, 25, 130, 28);
            ctx.fillStyle = '#10b981';
            ctx.font = 'bold 11px sans-serif';
            ctx.fillText('DISETUJUI', 475, 42);
        @elseif($registration->status === 'rejected')
            ctx.fillStyle = 'rgba(239, 68, 68, 0.15)';
            ctx.fillRect(440, 25, 130, 28);
            ctx.strokeStyle = '#ef4444';
            ctx.lineWidth = 1;
            ctx.strokeRect(440, 25, 130, 28);
            ctx.fillStyle = '#ef4444';
            ctx.font = 'bold 11px sans-serif';
            ctx.fillText('DITOLAK', 480, 42);
        @else
            ctx.fillStyle = 'rgba(245, 158, 11, 0.15)';
            ctx.fillRect(440, 25, 130, 28);
            ctx.strokeStyle = '#f59e0b';
            ctx.lineWidth = 1;
            ctx.strokeRect(440, 25, 130, 28);
            ctx.fillStyle = '#f59e0b';
            ctx.font = 'bold 11px sans-serif';
            ctx.fillText('SELESAI DIKIRIM', 460, 42);
        @endif

        // Card field tags
        ctx.fillStyle = '#94a3b8';
        ctx.font = 'bold 11px sans-serif';
        ctx.fillText('NOMOR REGISTRASI', 30, 120);
        ctx.fillStyle = '#fbbf24';
        ctx.font = 'bold 20px sans-serif';
        ctx.fillText(document.getElementById('cardRegNo').innerText, 30, 145);

        ctx.fillStyle = '#94a3b8';
        ctx.font = 'bold 11px sans-serif';
        ctx.fillText('NAMA LENGKAP PESERTA', 30, 185);
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 18px sans-serif';
        ctx.fillText(document.getElementById('cardName').innerText, 30, 210);

        ctx.fillStyle = '#94a3b8';
        ctx.font = 'bold 11px sans-serif';
        ctx.fillText('PROGRAM KURSUS TERPILIH', 30, 250);
        ctx.fillStyle = '#60a5fa';
        ctx.font = 'bold 16px sans-serif';
        
        // Wrap text for long course names
        const courseName = document.getElementById('cardCourse').innerText;
        if (courseName.length > 40) {
            ctx.fillText(courseName.substring(0, 40) + '...', 30, 272);
        } else {
            ctx.fillText(courseName, 30, 272);
        }

        // Draw date and verification footer
        ctx.fillStyle = '#94a3b8';
        ctx.font = '12px sans-serif';
        ctx.fillText('Tanggal Daftar: {{ $registration->created_at->format("d/m/Y H:i") }}', 30, 320);
        
        ctx.font = '12px sans-serif';
        @if($registration->status === 'approved')
            ctx.fillText('Verifikasi: Disetujui', 380, 320);
        @elseif($registration->status === 'rejected')
            ctx.fillText('Verifikasi: Ditolak', 380, 320);
        @else
            ctx.fillText('Verifikasi: Menunggu Admin', 380, 320);
        @endif

        // Load QR Code dynamically and draw it onto canvas
        const qrImg = new Image();
        qrImg.crossOrigin = 'anonymous'; // Enforce CORS allowance
        qrImg.onload = function() {
            // Draw background for QR
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(440, 105, 130, 135);

            ctx.drawImage(qrImg, 450, 115, 110, 110);
            
            ctx.fillStyle = '#0f172a';
            ctx.font = 'bold 10px sans-serif';
            ctx.fillText('PINDAI VERIFIKASI', 458, 233);

            // Trigger actual download of canvas image as a file
            const dataUrl = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'KARTU_DAFTAR_INKA_{{ $registration->nama_lengkap }}.png';
            link.href = dataUrl;
            link.click();
            showToast('Kartu Pendaftaran Anda berhasil diunduh sebagai gambar PNG!', 'success');
        };
        // Load QR source from the image element
        qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=https://lkpinka.com/verify/{{ $registration->id }}';
    }
</script>
@endsection
