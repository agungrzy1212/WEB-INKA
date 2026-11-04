@extends('layouts.app')

@section('title', 'Dasbor Administrator CMS')

@section('content')

    <div class="dashboard-layout">
        
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-profile">
                <div class="profile-avatar" style="background: var(--grad-red);">A</div>
                <div class="profile-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>Super Admin</span>
                </div>
            </div>
            
            <nav class="sidebar-menu">
                <div class="menu-item active" id="sideBtnPendaftar" onclick="switchAdminTab('pendaftar', this)">
                    <i class="fa-solid fa-users-viewfinder"></i> Verifikasi Pendaftar
                </div>
                <div class="menu-item" id="sideBtnRekap" onclick="switchAdminTab('rekap', this)">
                    <i class="fa-solid fa-chart-pie"></i> Rekap & Laporan
                </div>
                <div class="menu-item" id="sideBtnCms" onclick="switchAdminTab('cms', this)">
                    <i class="fa-solid fa-circle-nodes"></i> Konten Website (CMS)
                </div>
                <div class="menu-item" id="sideBtnKursus" onclick="switchAdminTab('kursus', this)">
                    <i class="fa-solid fa-graduation-cap"></i> Kelola Kursus
                </div>
                <div class="menu-item" id="sideBtnBerita" onclick="switchAdminTab('berita', this)">
                    <i class="fa-solid fa-newspaper"></i> Kelola Berita
                </div>
                <div class="menu-item" id="sideBtnGaleri" onclick="switchAdminTab('galeri', this)">
                    <i class="fa-solid fa-images"></i> Galeri Kegiatan
                </div>
                <a href="{{ route('logout') }}" class="menu-item">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                </a>
            </nav>
        </aside>

        <!-- MAIN AREA -->
        <main class="dashboard-main">
            
            <div class="dashboard-header">
                <h2 id="adminTabTitle">Verifikasi Pendaftar Kursus</h2>
                <div style="font-size: 0.9rem; font-weight: 700; color: var(--text-muted);">
                    <i class="fa-solid fa-shield-halved" style="color: var(--color-red);"></i> Mode Admin
                </div>
            </div>

            <!-- ================= TAB 1: PENDAFTAR ================= -->
            <div class="cms-tab-content active" id="tabPendaftar">
                
                <!-- Search bar -->
                <div style="margin-bottom: 25px; display: flex; justify-content: flex-end;">
                    <div style="position: relative; width: 100%; max-width: 350px;">
                        <input type="text" id="searchRegistrant" class="form-control" placeholder="Cari nama pendaftar..." style="padding-left: 40px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border: 1px solid #cbd5e1; height: 42px;">
                        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Program Kursus</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $index => $reg)
                                    <tr>
                                        <td style="font-weight: 700;">{{ $index + 1 }}</td>
                                        <td>
                                            <div style="font-weight: 700;">{{ $reg->nama_lengkap }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $reg->email }} | {{ $reg->nomer_hp }}</div>
                                        </td>
                                        <td style="font-weight: 600; color: var(--color-blue-primary);">{{ $reg->course->name }}</td>
                                        <td style="font-size: 0.85rem;">{{ $reg->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($reg->status === 'pending')
                                                <span class="status-pill status-pending"><i class="fa-solid fa-circle-notch fa-spin"></i> Pending</span>
                                            @elseif($reg->status === 'approved')
                                                <span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                                            @elseif($reg->status === 'rejected')
                                                <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px; align-items: center;">
                                                <button class="btn btn-primary btn-tinjau" style="padding: 8px 15px; font-size: 0.8rem;" 
                                                    data-id="{{ $reg->id }}"
                                                    data-nama="{{ $reg->nama_lengkap }}"
                                                    data-email="{{ $reg->email }}"
                                                    data-lahir="{{ \Carbon\Carbon::parse($reg->tanggal_lahir)->translatedFormat('d F Y') }}"
                                                    data-hp="{{ $reg->nomer_hp }}"
                                                    data-alamat="{{ $reg->alamat }}"
                                                    data-kursus="{{ $reg->course->name }}"
                                                    data-harga="Rp {{ number_format($reg->course->price, 0, ',', '.') }}"
                                                    data-ijazah="{{ route('berkas', ['file' => $reg->ijazah_path]) }}"
                                                    data-ktp="{{ route('berkas', ['file' => $reg->ktp_path]) }}"
                                                    data-kk="{{ route('berkas', ['file' => $reg->kk_path]) }}"
                                                    data-foto="{{ route('berkas', ['file' => $reg->pas_foto_path]) }}"
                                                    data-receipt="{{ $reg->payment_receipt_path ? route('berkas', ['file' => $reg->payment_receipt_path]) : '' }}"
                                                    data-status="{{ $reg->status }}"
                                                    data-notes="{{ $reg->admin_notes }}">
                                                    <i class="fa-solid fa-folder-open"></i> Tinjau Berkas
                                                </button>

                                                <form action="{{ route('admin.registrations.delete', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran kursus {{ $reg->course->name }} oleh {{ $reg->nama_lengkap }}?');" style="display: inline-block; margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="padding: 8px 15px; font-size: 0.8rem; height: 35px; border-radius: var(--radius-sm); font-weight: 700;">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            Belum ada calon peserta yang melakukan pendaftaran kursus saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 2: CMS CONTENT SETTINGS ================= -->
            <div class="cms-tab-content" id="tabCms">
                <form action="{{ route('admin.settings.update') }}" method="POST" class="glass-card" style="background: white;">
                    @csrf
                    
                    <h4 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-desktop" style="color: var(--color-blue-primary);"></i> Konten Halaman Home
                    </h4>

                    <div class="form-group">
                        <label for="home_hero_title">Judul Utama Hero (Home Title)</label>
                        <input type="text" name="home_hero_title" id="home_hero_title" class="form-control" required value="{{ $settings['home_hero_title'] }}">
                    </div>

                    <div class="form-group">
                        <label for="home_hero_subtitle">Sub-Judul Hero (Home Subtitle)</label>
                        <textarea name="home_hero_subtitle" id="home_hero_subtitle" class="form-control" rows="2" required>{{ $settings['home_hero_subtitle'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="home_cta_text">Teks Tombol CTA Utama (CTA Button)</label>
                        <input type="text" name="home_cta_text" id="home_cta_text" class="form-control" required value="{{ $settings['home_cta_text'] }}">
                    </div>

                    <h4 style="font-weight: 800; color: var(--color-blue-dark); margin-top: 40px; margin-bottom: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-address-card" style="color: var(--color-yellow);"></i> Konten Halaman Profil
                    </h4>

                    <div class="form-group">
                        <label for="profil_about">Tentang LKP INKA (About Us)</label>
                        <textarea name="profil_about" id="profil_about" class="form-control" rows="4" required>{{ $settings['profil_about'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="profil_sejarah">Sejarah Singkat LKP INKA (Sejarah)</label>
                        <textarea name="profil_sejarah" id="profil_sejarah" class="form-control" rows="4" required>{{ $settings['profil_sejarah'] ?? 'Didirikan di Wonosobo, LKP INKA lahir dari visi luhur untuk membantu mengurangi angka pengangguran melalui pembekalan keterampilan (vocational skills) yang aplikatif dan sesuai dengan pasar industri. Dimulai dengan kelas komputer dasar, kini LKP INKA telah berevolusi menyediakan 24 variasi program keterampilan berstandar nasional dan meluluskan puluhan ribu alumni yang sukses bekerja maupun mendirikan usaha mandiri di berbagai daerah.' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="profil_visi">Visi Lembaga (Visi)</label>
                        <textarea name="profil_visi" id="profil_visi" class="form-control" rows="2" required>{{ $settings['profil_visi'] }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="profil_misi">Misi Lembaga (Misi) - <em>Pisahkan setiap baris misi dengan menekan enter</em></label>
                        <textarea name="profil_misi" id="profil_misi" class="form-control" rows="4" required>{{ $settings['profil_misi'] }}</textarea>
                    </div>

                    <div style="text-align: right; margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Teks Halaman
                        </button>
                    </div>
                </form>
            </div>

            <!-- ================= TAB 3: MANAGE COURSES ================= -->
            <div class="cms-tab-content" id="tabKursus">
                
                <div style="text-align: right; margin-bottom: 25px;">
                    <button class="btn btn-primary" onclick="openAddCourseModal()">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Program Kursus Baru
                    </button>
                </div>

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Nama Program Kursus</th>
                                    <th>Durasi</th>
                                    <th>Biaya (Rupiah)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td><span class="status-pill status-approved" style="background: rgba(59,130,246,0.1); color: var(--color-blue-primary);">{{ $course->category }}</span></td>
                                        <td style="font-weight: 700; color: var(--color-blue-dark);">{{ $course->name }}</td>
                                        <td style="font-weight: 600;">{{ $course->duration }}</td>
                                        <td style="font-weight: 800; color: var(--color-red);">Rp {{ number_format($course->price, 0, ',', '.') }}</td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <button class="btn btn-yellow btn-edit-course" style="padding: 6px 12px; font-size: 0.75rem;" 
                                                    data-id="{{ $course->id }}"
                                                    data-name="{{ $course->name }}"
                                                    data-category="{{ $course->category }}"
                                                    data-price="{{ $course->price }}"
                                                    data-duration="{{ $course->duration }}"
                                                    data-description="{{ $course->description }}">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </button>
                                                
                                                <form action="{{ route('admin.courses.delete', $course->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kursus {{ $course->name }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.75rem;">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 4: MANAGE NEWS ================= -->
            <div class="cms-tab-content" id="tabBerita">
                
                <div style="text-align: right; margin-bottom: 25px;">
                    <button class="btn btn-primary" onclick="openAddNewsModal()">
                        <i class="fa-solid fa-circle-plus"></i> Terbitkan Berita Baru
                    </button>
                </div>

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul Berita / Artikel</th>
                                    <th>Isi Ringkas</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $item)
                                    <tr>
                                        <td style="font-size: 0.82rem;">{{ $item->created_at->format('d/m/Y') }}</td>
                                        <td style="font-weight: 700; color: var(--color-blue-dark); width: 250px;">{{ $item->title }}</td>
                                        <td style="font-size: 0.85rem; color: var(--text-muted);">{{ Str::limit($item->content, 120) }}</td>
                                        <td>
                                            @if($item->image_path)
                                                <img src="{{ asset('storage/' . $item->image_path) }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span style="font-size: 0.75rem; color: var(--text-muted);">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <button class="btn btn-yellow btn-edit-news" style="padding: 6px 12px; font-size: 0.75rem;" 
                                                    data-id="{{ $item->id }}"
                                                    data-title="{{ $item->title }}"
                                                    data-content="{{ $item->content }}">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </button>
                                                
                                                <form action="{{ route('admin.news.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita {{ $item->title }}?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.75rem;">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            Belum ada berita yang diterbitkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB 5: MANAGE GALLERY ================= -->
            <div class="cms-tab-content" id="tabGaleri">
                <div style="text-align: right; margin-bottom: 25px;">
                    <button class="btn btn-primary" onclick="openAddGalleryModal()">
                        <i class="fa-solid fa-circle-plus"></i> Tambah Foto Kegiatan
                    </button>
                </div>

                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto Kegiatan</th>
                                    <th>Judul (Opsional)</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleryImages as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($item->image_path)
                                                <img src="{{ asset('storage/' . $item->image_path) }}" style="width: 100px; height: 60px; object-fit: cover; border-radius: 6px; box-shadow: var(--shadow-sm);">
                                            @else
                                                <span style="font-size: 0.75rem; color: var(--text-muted);">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td style="font-weight: 600; color: var(--color-blue-dark);">{{ $item->title ?? '-' }}</td>
                                        <td style="font-size: 0.85rem;">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('admin.gallery.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto kegiatan ini?');">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.75rem;">
                                                    <i class="fa-solid fa-trash-can"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            Belum ada foto galeri kegiatan yang diunggah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= TAB: REKAP & LAPORAN ================= -->
            <div class="cms-tab-content" id="tabRekap">
                
                <!-- Quick Metric Cards -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px;">
                    <div style="background: white; border-radius: var(--radius-md); padding: 22px; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 18px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(29, 78, 216, 0.1); color: var(--color-blue-primary); display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Total Pendaftar</div>
                            <div style="font-size: 1.6rem; font-weight: 800; color: var(--color-blue-dark); line-height: 1.2;">{{ $totalAll }}</div>
                        </div>
                    </div>

                    <div style="background: white; border-radius: var(--radius-md); padding: 22px; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 18px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(16, 185, 129, 0.1); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Disetujui</div>
                            <div style="font-size: 1.6rem; font-weight: 800; color: #10b981; line-height: 1.2;">{{ $totalApproved }}</div>
                        </div>
                    </div>

                    <div style="background: white; border-radius: var(--radius-md); padding: 22px; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 18px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Menunggu (Pending)</div>
                            <div style="font-size: 1.6rem; font-weight: 800; color: #f59e0b; line-height: 1.2;">{{ $totalPending }}</div>
                        </div>
                    </div>

                    <div style="background: white; border-radius: var(--radius-md); padding: 22px; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 18px;">
                        <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(239, 68, 68, 0.1); color: var(--color-red); display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Ditolak</div>
                            <div style="font-size: 1.6rem; font-weight: 800; color: var(--color-red); line-height: 1.2;">{{ $totalRejected }}</div>
                        </div>
                    </div>
                </div>

                <!-- Section 1: Rekapitulasi Tahunan -->
                <div class="glass-card" style="margin-bottom: 30px; background: white;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h4 style="font-weight: 800; color: var(--color-blue-dark); font-size: 1.15rem; margin-bottom: 4px;">
                                <i class="fa-solid fa-calendar-days" style="color: var(--color-blue-primary); margin-right: 8px;"></i> Rekap Pendaftar Per Tahun
                            </h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Ringkasan total pendaftaran yang masuk pada setiap tahun ajaran/kalender.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Total Pendaftar</th>
                                    <th>Disetujui</th>
                                    <th>Pending</th>
                                    <th>Ditolak</th>
                                    <th>Aksi Cetak / Ekspor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapPerTahun as $rt)
                                    <tr>
                                        <td style="font-weight: 800; font-size: 1.05rem; color: var(--color-blue-dark);">
                                            <i class="fa-solid fa-folder" style="color: var(--color-yellow); margin-right: 6px;"></i> Tahun {{ $rt->year }}
                                        </td>
                                        <td><strong style="font-size: 1rem;">{{ $rt->total }}</strong> Calon Siswa</td>
                                        <td><span class="status-pill status-approved">{{ $rt->approved_count }}</span></td>
                                        <td><span class="status-pill status-pending">{{ $rt->pending_count }}</span></td>
                                        <td><span class="status-pill status-rejected">{{ $rt->rejected_count }}</span></td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="{{ route('admin.rekap.pdf', ['year' => $rt->year]) }}" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.78rem;" title="Cetak / PDF Rekap Tahun {{ $rt->year }}">
                                                    <i class="fa-solid fa-print"></i> PDF
                                                </a>
                                                <a href="{{ route('admin.rekap.excel', ['year' => $rt->year]) }}" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.78rem; background: #059669;" title="Ekspor Excel Tahun {{ $rt->year }}">
                                                    <i class="fa-solid fa-file-excel"></i> Excel
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                                            Belum ada data pendaftar kursus.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 2: Rekapitulasi Rinci Per Bulan & Filter Periode -->
                <div class="glass-card" style="background: white;">
                    <div style="margin-bottom: 25px;">
                        <h4 style="font-weight: 800; color: var(--color-blue-dark); font-size: 1.15rem; margin-bottom: 4px;">
                            <i class="fa-solid fa-filter" style="color: var(--color-blue-primary); margin-right: 8px;"></i> Rekap Pendaftar Per Bulan & Filter Laporan
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">Saring laporan berdasarkan tahun dan bulan untuk melihat data lengkap serta mencetaknya.</p>
                    </div>

                    <!-- Filter Control Toolbar -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: var(--radius-md); padding: 20px; margin-bottom: 25px;">
                        <form method="GET" action="{{ route('dashboard.admin') }}" id="rekapFilterForm" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
                            <input type="hidden" name="tab" value="rekap">

                            <div style="flex: 1; min-width: 160px;">
                                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">
                                    <i class="fa-solid fa-calendar"></i> Tahun
                                </label>
                                <select name="filter_year" id="filterYearSelect" class="form-control" style="height: 42px;">
                                    <option value="all" {{ $currentFilterYear === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                                    @foreach($availableYears as $y)
                                        <option value="{{ $y }}" {{ (string)$currentFilterYear === (string)$y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="flex: 1; min-width: 180px;">
                                <label style="display: block; font-size: 0.8rem; font-weight: 700; color: var(--text-primary); margin-bottom: 6px;">
                                    <i class="fa-solid fa-calendar-day"></i> Bulan
                                </label>
                                <select name="filter_month" id="filterMonthSelect" class="form-control" style="height: 42px;">
                                    <option value="" {{ empty($currentFilterMonth) ? 'selected' : '' }}>Semua Bulan</option>
                                    <option value="1" {{ $currentFilterMonth == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $currentFilterMonth == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $currentFilterMonth == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $currentFilterMonth == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $currentFilterMonth == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $currentFilterMonth == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $currentFilterMonth == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $currentFilterMonth == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $currentFilterMonth == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $currentFilterMonth == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $currentFilterMonth == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $currentFilterMonth == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>

                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <button type="submit" class="btn btn-primary" style="height: 42px; padding: 0 20px;">
                                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                                </button>
                                
                                <button type="button" onclick="printFilteredRekap()" class="btn btn-secondary" style="height: 42px; padding: 0 18px; border-color: #cbd5e1;">
                                    <i class="fa-solid fa-print"></i> Cetak PDF
                                </button>

                                <button type="button" onclick="exportFilteredRekap()" class="btn btn-primary" style="height: 42px; padding: 0 18px; background: #059669;">
                                    <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filtered Registrations Table -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <span style="font-size: 0.9rem; font-weight: 700; color: var(--color-blue-dark);">
                            Daftar Pendaftar Terpilih: <span style="color: var(--color-blue-primary);">{{ $filteredRegistrations->count() }} Data</span>
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="premium-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Registrasi</th>
                                    <th>Nama Siswa</th>
                                    <th>Program Kursus</th>
                                    <th>Tgl Daftar</th>
                                    <th>Biaya Kursus</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($filteredRegistrations as $idx => $item)
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td style="font-family: monospace; font-weight: 700; color: var(--color-blue-primary);">
                                            INKA-{{ $item->created_at->format('Y') }}-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: var(--color-blue-dark);">{{ $item->nama_lengkap }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $item->email }} | {{ $item->nomer_hp }}</div>
                                        </td>
                                        <td style="font-weight: 600;">{{ $item->course ? $item->course->name : ($item->course_name ?? '-') }}</td>
                                        <td style="font-size: 0.85rem;">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                        <td style="font-weight: 700;">Rp {{ number_format($item->course ? $item->course->price : 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->status === 'approved')
                                                <span class="status-pill status-approved"><i class="fa-solid fa-circle-check"></i> Disetujui</span>
                                            @elseif($item->status === 'rejected')
                                                <span class="status-pill status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                                            @else
                                                <span class="status-pill status-pending"><i class="fa-solid fa-clock"></i> Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                            Tidak ada data pendaftaran yang sesuai dengan pilihan filter periode di atas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- ==============================================
         MODAL 1: VERIFIKASI BERKAS PENDAFTAR 
         ============================================== -->
    <div class="modal-overlay" id="verifyModal">
        <div class="modal-content" style="max-width: 700px;">
            <div class="modal-header">
                <h3>Tinjau Dokumen Calon Siswa</h3>
                <button class="modal-close-btn" onclick="closeModal('verifyModal')">&times;</button>
            </div>
            
            <form id="verifyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="modal-applicant-detail-grid">
                        <div class="detail-block">
                            <h5>Nama Calon Siswa</h5>
                            <p id="vNama">-</p>
                        </div>
                        <div class="detail-block">
                            <h5>Program Kursus</h5>
                            <p id="vKursus" style="color: var(--color-blue-primary);">-</p>
                        </div>
                        <div class="detail-block">
                            <h5>Tanggal Lahir</h5>
                            <p id="vLahir">-</p>
                        </div>
                        <div class="detail-block">
                            <h5>Biaya & Nomer HP</h5>
                            <p id="vHP">-</p>
                        </div>
                        <div class="detail-block" style="grid-column: span 2;">
                            <h5>Alamat Tinggal</h5>
                            <p id="vAlamat">-</p>
                        </div>

                        <!-- DOCUMENT DOWNLOADING BUTTONS -->
                        <div class="doc-links-box">
                            <h5 style="margin-bottom: 12px;">Berkas Dokumen Syarat Asli:</h5>
                            <a href="#" id="dlIjazah" target="_blank" class="doc-download-btn"><i class="fa-solid fa-graduation-cap"></i> Lihat Ijazah</a>
                            <a href="#" id="dlKtp" target="_blank" class="doc-download-btn"><i class="fa-solid fa-id-card"></i> Lihat KTP</a>
                            <a href="#" id="dlKk" target="_blank" class="doc-download-btn"><i class="fa-solid fa-people-roof"></i> Lihat KK</a>
                            <a href="#" id="dlFoto" target="_blank" class="doc-download-btn"><i class="fa-solid fa-user-check"></i> Lihat Pas Foto</a>
                            <a href="#" id="dlReceipt" target="_blank" class="doc-download-btn" style="display: none; background: #f0fdf4; border-color: #bbf7d0; color: #166534;"><i class="fa-solid fa-receipt"></i> Lihat Bukti Bayar</a>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #e2e8f0; margin-top: 25px; padding-top: 25px;">
                        <h4 style="font-weight: 800; font-size: 1rem; color: var(--color-blue-dark); margin-bottom: 15px;">Tindakan Verifikasi</h4>
                        
                        <div class="form-group">
                            <label>Status Persetujuan Berkas <span>*</span></label>
                            <select name="status" id="vStatus" class="form-control" required>
                                <option value="approved">SETUJUI (Verifikasi Berhasil)</option>
                                <option value="rejected">TOLAK (Tolak untuk Perbaikan Berkas)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="vNotes">Catatan / Alasan Penolakan <em>(Catatan ini akan langsung tampil di dasbor calon siswa)</em></label>
                            <textarea name="admin_notes" id="vNotes" class="form-control" rows="2" placeholder="contoh: Foto copy Kartu Keluarga (KK) buram, harap unggah kembali berkas KK asli secara jelas..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('verifyModal')">Tutup</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Simpan Hasil Verifikasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==============================================
         MODAL 2: ADD / EDIT COURSE
         ============================================== -->
    <div class="modal-overlay" id="courseModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="courseModalTitle">Tambah Program Kursus Baru</h3>
                <button class="modal-close-btn" onclick="closeModal('courseModal')">&times;</button>
            </div>
            
            <form id="courseForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cName">Nama Program Kursus <span>*</span></label>
                        <input type="text" name="name" id="cName" class="form-control" placeholder="contoh: PROGRAM KOMPUTER (DESAIN GRAFIS)" required>
                    </div>

                    <div class="form-group">
                        <label for="cCategory">Kategori Bidang <span>*</span></label>
                        <select name="category" id="cCategory" class="form-control" required>
                            <option value="Komputer">Komputer</option>
                            <option value="Mengemudi">Mengemudi</option>
                            <option value="Otomotif">Otomotif</option>
                            <option value="Menjahit">Menjahit</option>
                            <option value="Kerajinan">Kerajinan</option>
                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                            <option value="Bahasa Asing">Bahasa Asing</option>
                            <option value="Kecantikan">Kecantikan</option>
                            <option value="Elektro">Elektro</option>
                            <option value="Spa">Spa</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cPrice">Biaya Administrasi & Kelas (Rupiah) <span>*</span></label>
                            <input type="number" name="price" id="cPrice" class="form-control" placeholder="contoh: 750000" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="cDuration">Durasi Program <span>*</span></label>
                            <input type="text" name="duration" id="cDuration" class="form-control" placeholder="contoh: 2 Bulan" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cDescription">Deskripsi Lengkap Program</label>
                        <textarea name="description" id="cDescription" class="form-control" rows="3" placeholder="Masukkan ringkasan silabus dan deskripsi kemampuan yang akan dikuasai oleh siswa..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('courseModal')">Batal</button>
                    <button type="submit" class="btn btn-primary" id="cSubmitBtn"><i class="fa-solid fa-floppy-disk"></i> Simpan Program</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==============================================
         MODAL 3: ADD / EDIT NEWS
         ============================================== -->
    <div class="modal-overlay" id="newsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="newsModalTitle">Terbitkan Berita Baru</h3>
                <button class="modal-close-btn" onclick="closeModal('newsModal')">&times;</button>
            </div>
            
            <form id="newsForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nTitle">Judul Berita / Pengumuman <span>*</span></label>
                        <input type="text" name="title" id="nTitle" class="form-control" placeholder="Masukkan judul utama berita..." required>
                    </div>

                    <div class="form-group">
                        <label for="nImage">Gambar Unggulan (Cover) <em>(Opsional)</em></label>
                        <input type="file" name="image" id="nImage" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="nContent">Konten Berita Lengkap <span>*</span></label>
                        <textarea name="content" id="nContent" class="form-control" rows="6" placeholder="Tulis isi berita lengkap di sini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('newsModal')">Batal</button>
                    <button type="submit" class="btn btn-primary" id="nSubmitBtn"><i class="fa-solid fa-floppy-disk"></i> Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==============================================
         MODAL 4: ADD GALLERY PHOTO
         ============================================== -->
    <div class="modal-overlay" id="galleryModal">
        <div class="modal-content" style="max-width: 500px;">
            <div class="modal-header">
                <h3>Tambah Foto Kegiatan</h3>
                <button class="modal-close-btn" onclick="closeModal('galleryModal')">&times;</button>
            </div>
            
            <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="gTitle">Judul / Keterangan Foto <em>(Opsional)</em></label>
                        <input type="text" name="title" id="gTitle" class="form-control" placeholder="contoh: Kegiatan Praktik Komputer">
                    </div>

                    <div class="form-group">
                        <label for="gImage">File Foto Kegiatan <span>*</span></label>
                        <input type="file" name="image" id="gImage" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('galleryModal')">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cloud-arrow-up"></i> Unggah Foto</button>
                </div>
            </form>
        </div>
    </div>



@endsection

@section('scripts')
<script>
    // Tab switching inside Dashboard main
    function switchAdminTab(tabId, clickedBtn) {
        // Toggle Active Sidebar Buttons
        document.querySelectorAll('.sidebar-menu .menu-item').forEach(el => el.classList.remove('active'));
        clickedBtn.classList.add('active');

        // Toggle Dynamic Tab Panels
        document.querySelectorAll('.cms-tab-content').forEach(el => el.classList.remove('active'));
        
        let titleText = 'Verifikasi Pendaftar Kursus';
        if (tabId === 'pendaftar') {
            document.getElementById('tabPendaftar').classList.add('active');
            titleText = 'Verifikasi Pendaftar Kursus';
        } else if (tabId === 'rekap') {
            document.getElementById('tabRekap').classList.add('active');
            titleText = 'Rekapitulasi Pendaftar & Laporan';
        } else if (tabId === 'cms') {
            document.getElementById('tabCms').classList.add('active');
            titleText = 'Kelola Konten Website (CMS)';
        } else if (tabId === 'kursus') {
            document.getElementById('tabKursus').classList.add('active');
            titleText = 'Kelola Program Kursus (24 Pilihan)';
        } else if (tabId === 'berita') {
            document.getElementById('tabBerita').classList.add('active');
            titleText = 'Kelola Berita & Pengumuman';
        } else if (tabId === 'galeri') {
            document.getElementById('tabGaleri').classList.add('active');
            titleText = 'Kelola Galeri Kegiatan';
        }
        
        document.getElementById('adminTabTitle').innerText = titleText;

        // Remember active tab in session and browser URL without full reload
        try {
            sessionStorage.setItem('adminActiveTab', tabId);
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('tab', tabId);
            window.history.replaceState({}, '', currentUrl);
        } catch (e) {}
    }

    function printFilteredRekap() {
        const year = document.getElementById('filterYearSelect').value;
        const month = document.getElementById('filterMonthSelect').value;
        const url = `{{ route('admin.rekap.pdf') }}?year=${encodeURIComponent(year)}&month=${encodeURIComponent(month)}`;
        window.location.href = url;
    }

    function exportFilteredRekap() {
        const year = document.getElementById('filterYearSelect').value;
        const month = document.getElementById('filterMonthSelect').value;
        const url = `{{ route('admin.rekap.excel') }}?year=${encodeURIComponent(year)}&month=${encodeURIComponent(month)}`;
        window.location.href = url;
    }

    // Modal Manager
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('active');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('active');
    }

    // Modal 1: Open verification modal
    function openVerifyModal(data) {
        // Set dynamic URL action for form submit
        document.getElementById('verifyForm').action = `/admin/registrations/${data.id}/action`;

        // Set detailed text fields
        document.getElementById('vNama').innerText = data.nama + ' (' + data.email + ')';
        document.getElementById('vKursus').innerText = data.kursus;
        document.getElementById('vLahir').innerText = data.lahir;
        document.getElementById('vHP').innerText = data.harga + ' | ' + data.hp;
        document.getElementById('vAlamat').innerText = data.alamat;

        // Set download anchors
        document.getElementById('dlIjazah').href = data.ijazah;
        document.getElementById('dlKtp').href = data.ktp;
        document.getElementById('dlKk').href = data.kk;
        document.getElementById('dlFoto').href = data.foto;

        // If payment receipt exists, show button
        const dlReceiptBtn = document.getElementById('dlReceipt');
        if (data.receipt) {
            dlReceiptBtn.href = data.receipt;
            dlReceiptBtn.style.display = 'inline-flex';
        } else {
            dlReceiptBtn.style.display = 'none';
        }

        // Set status values in dropdown & notes
        document.getElementById('vStatus').value = data.status === 'pending' ? 'approved' : data.status;
        document.getElementById('vNotes').value = data.notes;

        openModal('verifyModal');
    }

    // Modal 2: Add Course Modal
    function openAddCourseModal() {
        document.getElementById('courseForm').action = '{{ route("admin.courses.store") }}';
        document.getElementById('courseModalTitle').innerText = 'Tambah Program Kursus Baru';
        document.getElementById('cSubmitBtn').innerHTML = '<i class="fa-solid fa-circle-plus"></i> Tambah Program';

        // Clear values
        document.getElementById('cName').value = '';
        document.getElementById('cCategory').value = 'Komputer';
        document.getElementById('cPrice').value = '';
        document.getElementById('cDuration').value = '';
        document.getElementById('cDescription').value = '';

        openModal('courseModal');
    }

    // Modal 2: Edit Course Modal
    function openEditCourseModal(data) {
        document.getElementById('courseForm').action = `/admin/courses/${data.id}/update`;
        document.getElementById('courseModalTitle').innerText = 'Edit Program Kursus';
        document.getElementById('cSubmitBtn').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan';

        // Prefill values
        document.getElementById('cName').value = data.name;
        document.getElementById('cCategory').value = data.category;
        document.getElementById('cPrice').value = data.price;
        document.getElementById('cDuration').value = data.duration;
        document.getElementById('cDescription').value = data.description;

        openModal('courseModal');
    }

    // Modal 3: Add News Modal
    function openAddNewsModal() {
        document.getElementById('newsForm').action = '{{ route("admin.news.store") }}';
        document.getElementById('newsModalTitle').innerText = 'Terbitkan Berita Baru';
        document.getElementById('nSubmitBtn').innerHTML = '<i class="fa-solid fa-globe"></i> Terbitkan Berita';

        // Clear values
        document.getElementById('nTitle').value = '';
        document.getElementById('nContent').value = '';
        document.getElementById('nImage').value = '';

        openModal('newsModal');
    }

    // Modal 3: Edit News Modal
    function openEditNewsModal(data) {
        document.getElementById('newsForm').action = `/admin/news/${data.id}/update`;
        document.getElementById('newsModalTitle').innerText = 'Edit Berita';
        document.getElementById('nSubmitBtn').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Simpan Berita';

        // Prefill values
        document.getElementById('nTitle').value = data.title;
        document.getElementById('nContent').value = data.content;
        document.getElementById('nImage').value = ''; // Reset image input

        openModal('newsModal');
    }

    // Modal 4: Add Gallery Photo
    function openAddGalleryModal() {
        document.getElementById('gTitle').value = '';
        document.getElementById('gImage').value = '';
        openModal('galleryModal');
    }

    // Bind click events to all buttons with data attributes to prevent newline break syntax errors
    document.addEventListener('DOMContentLoaded', () => {
        // Tinjau Berkas Button
        document.querySelectorAll('.btn-tinjau').forEach(button => {
            button.addEventListener('click', function() {
                openVerifyModal(this.dataset);
            });
        });

        // Edit Course Button
        document.querySelectorAll('.btn-edit-course').forEach(button => {
            button.addEventListener('click', function() {
                openEditCourseModal(this.dataset);
            });
        });

        // Edit News Button
        document.querySelectorAll('.btn-edit-news').forEach(button => {
            button.addEventListener('click', function() {
                openEditNewsModal(this.dataset);
            });
        });



        // Registrant search filter
        const searchInput = document.getElementById('searchRegistrant');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('#tabPendaftar tbody tr');
                let foundAny = false;

                rows.forEach(row => {
                    // Check if it's the empty row
                    if (row.querySelector('td[colspan="6"]') && row.id !== 'search-empty-row') {
                        return; // skip the default empty row
                    }
                    if (row.id === 'search-empty-row') {
                        return; // skip custom empty search row
                    }

                    const nameDiv = row.cells[1] ? row.cells[1].querySelector('div') : null;
                    if (nameDiv) {
                        const name = nameDiv.textContent.toLowerCase();
                        if (name.includes(query)) {
                            row.style.display = '';
                            foundAny = true;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });

                // Handle show/hide of empty result row if nothing is found
                let emptyRow = document.getElementById('search-empty-row');
                if (!foundAny && query !== '') {
                    if (!emptyRow) {
                        emptyRow = document.createElement('tr');
                        emptyRow.id = 'search-empty-row';
                        emptyRow.innerHTML = `
                            <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                                Tidak ada pendaftar dengan nama "${this.value}" ditemukan.
                            </td>
                        `;
                        document.querySelector('#tabPendaftar tbody').appendChild(emptyRow);
                    } else {
                        emptyRow.style.display = '';
                        emptyRow.querySelector('td').innerText = `Tidak ada pendaftar dengan nama "${this.value}" ditemukan.`;
                    }
                } else if (emptyRow) {
                    emptyRow.style.display = 'none';
                }
            });
        }

        // Check if specific tab requested via URL query string (e.g. ?tab=rekap) or saved in sessionStorage
        const urlParams = new URLSearchParams(window.location.search);
        let activeTab = urlParams.get('tab') || sessionStorage.getItem('adminActiveTab');

        const tabBtnMap = {
            'pendaftar': document.getElementById('sideBtnPendaftar'),
            'rekap': document.getElementById('sideBtnRekap'),
            'cms': document.getElementById('sideBtnCms'),
            'kursus': document.getElementById('sideBtnKursus'),
            'berita': document.getElementById('sideBtnBerita'),
            'galeri': document.getElementById('sideBtnGaleri')
        };

        if (activeTab && tabBtnMap[activeTab]) {
            switchAdminTab(activeTab, tabBtnMap[activeTab]);
        }
    });
</script>
@endsection
