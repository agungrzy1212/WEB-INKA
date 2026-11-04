@extends('layouts.app')

@section('title', 'Dasbor Calon Peserta Kursus')

@section('content')

    <div class="dashboard-layout">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-profile">
                <div class="profile-avatar">{{ substr($user->name, 0, 1) }}</div>
                <div class="profile-info">
                    <h4>{{ $user->name }}</h4>
                    <span>Calon Peserta</span>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="menu-item active">
                    <i class="fa-solid fa-house-chimney"></i> Status Pendaftaran
                </div>
                <a href="{{ route('pendaftaran') }}" class="menu-item">
                    <i class="fa-solid fa-file-signature"></i> Formulir Pendaftaran
                </a>
                <a href="{{ route('kursus') }}" class="menu-item">
                    <i class="fa-solid fa-graduation-cap"></i> Pilihan Kursus
                </a>
                <a href="{{ route('logout') }}" class="menu-item">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                </a>
            </nav>
        </aside>

        <!-- MAIN AREA -->
        <main class="dashboard-main">
            
            <div class="dashboard-header">
                <h2>Dasbor Calon Peserta</h2>
                <div style="font-size: 0.9rem; font-weight: 700; color: var(--text-muted);">
                    <i class="fa-regular fa-clock"></i> Sesi Aktif: {{ $user->email }}
                </div>
            </div>

            <!-- NO REGISTRATION IN PROGRESS -->
            @if($registrations->isEmpty())
                <div class="glass-card" style="background: white; text-align: center; padding: 50px 30px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 4rem; color: var(--text-muted); margin-bottom: 20px;"></i>
                    <h3 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 10px;">Anda Belum Mendaftar Kursus</h3>
                    <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 30px auto; font-size: 0.95rem; line-height: 1.6;">
                        Silakan lengkapi formulir pendaftaran dengan memilih salah satu dari 24 program keterampilan unggulan LKP INKA Wonosobo untuk mulai belajar.
                    </p>
                    <a href="{{ route('pendaftaran') }}" class="btn btn-primary">
                        <i class="fa-solid fa-file-signature"></i> Isi Formulir Sekarang
                    </a>
                </div>
            @else
                <!-- DYNAMIC REGISTRATION HISTORY TABLE -->
                <div class="glass-card" style="background: white; padding: 25px; margin-bottom: 35px; border: 1px solid #e2e8f0; box-shadow: var(--shadow-premium);">
                    <h4 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 15px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-clock-rotate-left" style="color: var(--color-blue-primary);"></i> Riwayat Pendaftaran Kursus
                    </h4>
                    <div style="overflow-x: auto;">
                        <table class="premium-table" style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0; text-align: left; background: #f8fafc;">
                                    <th style="padding: 12px; font-weight: 700; width: 60px;">No</th>
                                    <th style="padding: 12px; font-weight: 700;">Program Kursus</th>
                                    <th style="padding: 12px; font-weight: 700;">Tanggal Daftar</th>
                                    <th style="padding: 12px; font-weight: 700;">Status</th>
                                    <th style="padding: 12px; font-weight: 700; text-align: center; width: 220px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $index => $reg)
                                    <tr style="border-bottom: 1px solid #f1f5f9; transition: all 0.2s; @if($registration && $registration->id === $reg->id) background: rgba(59, 130, 246, 0.05); font-weight: 600; border-left: 4px solid var(--color-blue-primary); @endif">
                                        <td style="padding: 12px;">{{ $index + 1 }}</td>
                                        <td style="padding: 12px;">
                                            <div style="color: var(--color-blue-dark); font-weight: 700;">{{ $reg->course->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $reg->course->category }} (Rp {{ number_format($reg->course->price, 0, ',', '.') }})</div>
                                        </td>
                                        <td style="padding: 12px; font-size: 0.85rem; color: var(--text-muted);">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                                        <td style="padding: 12px;">
                                            @if($reg->status === 'pending')
                                                <span class="status-pill status-pending" style="padding: 4px 8px; font-size: 0.75rem;"><i class="fa-solid fa-circle-notch fa-spin"></i> Pending</span>
                                            @elseif($reg->status === 'approved')
                                                <span class="status-pill status-approved" style="padding: 4px 8px; font-size: 0.75rem;"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                                            @elseif($reg->status === 'rejected')
                                                <span class="status-pill status-rejected" style="padding: 4px 8px; font-size: 0.75rem;"><i class="fa-solid fa-circle-xmark"></i> Perlu Perbaikan</span>
                                            @endif
                                        </td>
                                        <td style="padding: 12px; text-align: center;">
                                            <div style="display: inline-flex; gap: 8px; justify-content: center;">
                                                <a href="{{ route('dashboard.siswa', ['id' => $reg->id]) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.75rem; font-weight: 700;">
                                                    <i class="fa-solid fa-eye"></i> Detail
                                                </a>
                                                @if($reg->status === 'approved')
                                                    <a href="{{ route('pendaftaran.bukti', ['id' => $reg->id]) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem; font-weight: 700;">
                                                        <i class="fa-solid fa-print"></i> Bukti
                                                    </a>
                                                @elseif($reg->status === 'rejected')
                                                    <a href="{{ route('pendaftaran', ['course_id' => $reg->course_id]) }}" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.75rem; font-weight: 700;">
                                                        <i class="fa-solid fa-file-pen"></i> Perbaiki
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($registration)
                    <!-- SELECTED REGISTRATION STATUS & DETAILS -->
                    <div style="background: #f8fafc; border-radius: var(--radius-lg); padding: 5px; margin-bottom: 20px; border: 1px solid #e2e8f0;">
                        <h4 style="font-weight: 800; color: var(--color-blue-dark); margin: 15px 0 15px 15px; font-size: 1.05rem;">
                            <i class="fa-solid fa-circle-info" style="color: var(--color-blue-primary);"></i> Detail Pendaftaran Aktif: <span style="color: var(--color-blue-primary);">{{ $registration->course->name }}</span>
                        </h4>
                    </div>

                    <!-- STATUS BANNER ALERTS -->
                    @if($registration->status === 'pending')
                        <div style="background: rgba(245, 158, 11, 0.08); border-left: 5px solid var(--color-yellow); border-radius: var(--radius-md); padding: 25px; margin-bottom: 35px; box-shadow: var(--shadow-premium); border: 1px solid rgba(245,158,11,0.15); border-left-width: 5px;">
                            <h4 style="font-weight: 800; color: var(--color-blue-dark); font-size: 1.15rem; margin-bottom: 8px;">
                                <i class="fa-solid fa-rotate" style="color: var(--color-yellow); animation: spin 4s infinite linear;"></i> Status: Menunggu Verifikasi Dokumen
                            </h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 15px;">
                                Berkas dokumen fisik dan administrasi Anda saat ini sedang diperiksa dan ditinjau oleh staf verifikator LKP INKA Wonosobo. Proses verifikasi biasanya memakan waktu maksimal 1x24 jam kerja.
                            </p>
                            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                <a href="{{ route('pendaftaran', ['course_id' => $registration->course_id]) }}" class="btn btn-primary" style="padding: 8px 18px; font-size: 0.85rem;">
                                    <i class="fa-solid fa-file-arrow-up"></i> Perbarui / Kirim Ulang Berkas
                                </a>
                                <form action="{{ route('pendaftaran.cancel', $registration->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini? Semua berkas akan dihapus.');" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.85rem; height: 100%;">
                                        <i class="fa-solid fa-trash-can"></i> Batalkan Pendaftaran
                                    </button>
                                </form>
                                <a href="{{ route('pendaftaran.bukti', ['id' => $registration->id]) }}" class="btn btn-yellow" style="padding: 8px 18px; font-size: 0.85rem;">
                                    <i class="fa-solid fa-id-card"></i> Lihat Kartu Tanda Daftar
                                </a>
                            </div>
                        </div>
                    @elseif($registration->status === 'approved')
                        <div style="background: rgba(16, 185, 129, 0.08); border-left: 5px solid #10b981; border-radius: var(--radius-md); padding: 25px; margin-bottom: 35px; box-shadow: var(--shadow-premium); border: 1px solid rgba(16,185,129,0.15); border-left-width: 5px;">
                            <h4 style="font-weight: 800; color: var(--color-blue-dark); font-size: 1.15rem; margin-bottom: 8px;">
                                <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> Status: Pendaftaran Telah Disetujui!
                            </h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 15px;">
                                Selamat! Berkas dan bukti bayar Anda telah diverifikasi oleh Admin. Anda resmi terdaftar sebagai Peserta Kursus LKP INKA Wonosobo. Silakan cetak bukti pendaftaran Anda dan bawa saat hari pertama kelas dimulai.
                            </p>
                            @if($registration->admin_notes)
                                <div style="background: white; border-radius: var(--radius-sm); padding: 12px; font-size: 0.85rem; border-left: 3px solid #10b981; margin-bottom: 15px; font-weight: 600; color: var(--color-blue-dark);">
                                    <i class="fa-solid fa-comment-dots"></i> Catatan Admin: {{ $registration->admin_notes }}
                                </div>
                            @endif
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('pendaftaran.bukti', ['id' => $registration->id]) }}" class="btn btn-primary" style="padding: 8px 18px; font-size: 0.85rem;">
                                    <i class="fa-solid fa-print"></i> Cetak/Unduh Bukti PDF
                                </a>
                                <span class="btn btn-secondary" style="padding: 8px 18px; font-size: 0.85rem; cursor: default; pointer-events: none;">
                                    <i class="fa-solid fa-circle-play" style="color: #10b981;"></i> Kelas Aktif
                                </span>
                            </div>
                        </div>
                    @elseif($registration->status === 'rejected')
                        <div style="background: rgba(239, 68, 68, 0.08); border-left: 5px solid var(--color-red); border-radius: var(--radius-md); padding: 25px; margin-bottom: 35px; box-shadow: var(--shadow-premium); border: 1px solid rgba(239,68,68,0.15); border-left-width: 5px;">
                            <h4 style="font-weight: 800; color: var(--color-blue-dark); font-size: 1.15rem; margin-bottom: 8px;">
                                <i class="fa-solid fa-triangle-exclamation" style="color: var(--color-red);"></i> Status: Pendaftaran Perlu Perbaikan Berkas
                            </h4>
                            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6; margin-bottom: 15px;">
                                Mohon maaf, berkas pendaftaran atau administrasi Anda ditolak oleh staf kami dikarenakan beberapa ketidaksesuaian syarat berkas.
                            </p>
                            @if($registration->admin_notes)
                                <div style="background: white; border-radius: var(--radius-sm); padding: 15px; font-size: 0.88rem; border-left: 4px solid var(--color-red); margin-bottom: 20px; font-weight: 700; color: var(--color-red);">
                                    <i class="fa-solid fa-circle-info"></i> Alasan Penolakan: {{ $registration->admin_notes }}
                                </div>
                            @endif
                            <a href="{{ route('pendaftaran', ['course_id' => $registration->course_id]) }}" class="btn btn-danger" style="padding: 8px 18px; font-size: 0.85rem;">
                                <i class="fa-solid fa-file-pen"></i> Perbaiki & Kirim Ulang Berkas
                            </a>
                        </div>
                    @endif

                <!-- DETAILS OVERVIEW GRID -->
                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 30px;">
                    
                    <!-- Applicant details card -->
                    <div class="glass-card" style="background: white; padding: 30px;">
                        <h4 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                            <i class="fa-solid fa-id-card-clip" style="color: var(--color-blue-primary);"></i> Data Diri Pendaftar
                        </h4>
                        
                        <table style="width: 100%; font-size: 0.92rem;" cellpadding="10" cellspacing="0">
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600; width: 180px;">Nomor Registrasi:</td>
                                <td style="font-weight: 700; color: var(--color-blue-primary);">INKA-{{ date('Y') }}-{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Program Kursus:</td>
                                <td style="font-weight: 700;">{{ $registration->course->name }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Kategori & Biaya:</td>
                                <td style="font-weight: 700; color: var(--color-red);">{{ $registration->course->category }} (Rp {{ number_format($registration->course->price, 0, ',', '.') }})</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Nama Lengkap:</td>
                                <td style="font-weight: 700;">{{ $registration->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Tanggal Lahir:</td>
                                <td>{{ \Carbon\Carbon::parse($registration->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Nomor HP (WA):</td>
                                <td>{{ $registration->nomer_hp }}</td>
                            </tr>
                            <tr>
                                <td style="color: var(--text-muted); font-weight: 600;">Alamat Lengkap:</td>
                                <td style="line-height: 1.4;">{{ $registration->alamat }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Uploaded files card preview -->
                    <div class="glass-card" style="background: white; padding: 30px;">
                        <h4 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                            <i class="fa-solid fa-file-shield" style="color: var(--color-yellow);"></i> Dokumen Terunggah
                        </h4>
                        
                        <div style="display: grid; gap: 12px; font-size: 0.85rem;">
                            
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid #e2e8f0;">
                                <span style="font-weight: 700;"><i class="fa-solid fa-graduation-cap" style="color: var(--color-blue-primary);"></i> Ijazah Terakhir</span>
                                <a href="{{ route('berkas', ['file' => $registration->ijazah_path]) }}" target="_blank" style="color: var(--color-blue-primary); font-weight: 800;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                </a>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid #e2e8f0;">
                                <span style="font-weight: 700;"><i class="fa-solid fa-id-card-clip" style="color: var(--color-yellow);"></i> KTP / Kartu Identitas</span>
                                <a href="{{ route('berkas', ['file' => $registration->ktp_path]) }}" target="_blank" style="color: var(--color-blue-primary); font-weight: 800;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                </a>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid #e2e8f0;">
                                <span style="font-weight: 700;"><i class="fa-solid fa-people-roof" style="color: var(--color-red);"></i> Kartu Keluarga (KK)</span>
                                <a href="{{ route('berkas', ['file' => $registration->kk_path]) }}" target="_blank" style="color: var(--color-blue-primary); font-weight: 800;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                </a>
                            </div>

                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f8fafc; border-radius: var(--radius-sm); border: 1px solid #e2e8f0;">
                                <span style="font-weight: 700;"><i class="fa-solid fa-user-check" style="color: var(--color-blue-light);"></i> Pas Foto Resmi 3x4</span>
                                <a href="{{ route('berkas', ['file' => $registration->pas_foto_path]) }}" target="_blank" style="color: var(--color-blue-primary); font-weight: 800;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                </a>
                            </div>

                            @if($registration->payment_receipt_path)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 15px; background: #f0fdf4; border-radius: var(--radius-sm); border: 1px solid #bbf7d0;">
                                    <span style="font-weight: 700; color: #166534;"><i class="fa-solid fa-receipt"></i> Bukti Pembayaran</span>
                                    <a href="{{ route('berkas', ['file' => $registration->payment_receipt_path]) }}" target="_blank" style="color: #166534; font-weight: 800;">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            @endif
        @endif

        </main>
    </div>

    <style>
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>

@endsection
