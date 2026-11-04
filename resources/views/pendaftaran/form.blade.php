@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Kursus')

@section('content')

    <section class="section-wrapper" style="margin-top: 40px;">
        
        <div class="section-header" style="margin-bottom: 30px;">
            <h2>Formulir <span>Pendaftaran Kursus</span></h2>
            <p>Silakan isi seluruh tahapan pendaftaran di bawah ini secara lengkap dengan berkas dokumen asli.</p>
        </div>

        <div class="reg-container">
            @if($registration && $registration->status === 'pending')
            <div style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid var(--color-yellow); padding: 15px 20px; border-radius: var(--radius-md); margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between; gap: 15px; flex-wrap: wrap;">
                <div>
                    <h4 style="color: #d97706; font-weight: 800; font-size: 1rem; margin-bottom: 5px;"><i class="fa-solid fa-clock-rotate-left"></i> Status Pendaftaran: PENDING</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Pendaftaran Anda sedang menunggu verifikasi admin. Anda dapat <strong>memperbarui/mengirim ulang berkas</strong> dengan mengubah form di bawah dan klik "Perbarui Pendaftaran", atau membatalkan pendaftaran ini.</p>
                </div>
                <div>
                    <form action="{{ route('pendaftaran.cancel', $registration->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pendaftaran ini? Semua data dan berkas akan dihapus.')" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding: 8px 15px; font-size: 0.85rem;"><i class="fa-solid fa-trash-can"></i> Batalkan Pendaftaran</button>
                    </form>
                </div>
            </div>
            @endif
            
            <!-- STEP INDICATOR NODES -->
            <div class="step-indicator">
                <div class="step-progress-bar" id="stepProgressBar"></div>
                <div class="step-node active" data-step="1">
                    1
                    <span>Data Diri</span>
                </div>
                <div class="step-node" data-step="2">
                    2
                    <span>Syarat Berkas</span>
                </div>
                <div class="step-node" data-step="3">
                    3
                    <span>Pembayaran</span>
                </div>
                <div class="step-node" data-step="4">
                    4
                    <span>Review Data</span>
                </div>
            </div>

            <!-- FORM CORE -->
            <form action="{{ route('pendaftaran.submit') }}" method="POST" enctype="multipart/form-data" class="glass-card" style="background: white; padding: 40px; margin-top: 50px;" id="regForm">
                @csrf
                
                <!-- STEP 1: PERSONAL INFO -->
                <div class="form-step-content active" data-step="1">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-user-tie" style="color: var(--color-blue-primary);"></i> Tahap 1: Data Diri & Program Kursus
                    </h4>

                    <div class="form-group">
                        <label for="course_id">Program Kursus yang Diikuti <span>*</span></label>
                        @php
                            $preselectedCourseId = old('course_id', $selectedCourseId ?? '');
                            if (!$preselectedCourseId && $registration && $registration->status !== 'approved') {
                                $preselectedCourseId = $registration->course_id;
                            }
                        @endphp
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="" disabled @if(!$preselectedCourseId) selected @endif>-- Pilih Program Kursus (Tersedia 24 Program) --</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" 
                                    @if($preselectedCourseId == $c->id) selected @endif
                                    data-price="Rp {{ number_format($c->price, 0, ',', '.') }}">
                                    {{ $c->name }} ({{ $c->category }} - {{ $c->duration }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap <span>*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap sesuai ijazah..." required value="{{ old('nama_lengkap', $registration?->nama_lengkap ?? Auth::user()->name) }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir <span>*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir', $registration?->tanggal_lahir ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label for="nomer_hp">Nomer HP (Aktif WhatsApp) <span>*</span></label>
                            <input type="text" name="nomer_hp" id="nomer_hp" class="form-control" placeholder="contoh: 081234567890" required value="{{ old('nomer_hp', $registration?->nomer_hp ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Alamat Email <span>*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="contoh: budi@gmail.com" required value="{{ old('email', $registration?->email ?? Auth::user()->email) }}">
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap Rumah (Sesuai KTP) <span>*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Nama Jalan, RT/RW, Dusun, Desa/Kelurahan, Kecamatan, Kabupaten Wonosobo..." required>{{ old('alamat', $registration?->alamat ?? '') }}</textarea>
                    </div>
                </div>

                <!-- STEP 2: DOCUMENTS UPLOADS -->
                <div class="form-step-content" data-step="2">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: var(--color-blue-dark); margin-bottom: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-folder-open" style="color: var(--color-yellow);"></i> Tahap 2: Unggah Dokumen Syarat Berkas
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">Unggah dokumen asli pendukung berformat gambar (.JPG/.PNG) atau dokumen (.PDF) dengan ukuran maksimal 2MB per file.</p>

                    <div class="upload-grid">
                        <!-- File 1: Ijazah -->
                        <div class="form-group">
                            <label>Foto Copy Ijazah Terakhir <span>*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('ijazah').click();">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <h5>Klik / Seret Berkas Ijazah</h5>
                                <p>Format: PDF, JPG, PNG (Max 2MB)</p>
                                <input type="file" name="ijazah" id="ijazah" accept="image/*,.pdf" @if(!$registration) required @endif onchange="handleFileSelect(this, 'ijazahPreview', 'ijazahBadge')">
                                <span class="file-info-badge" id="ijazahBadge">Berkas terpilih</span>
                                <img src="" class="file-preview" id="ijazahPreview">
                                @if($registration?->ijazah_path)
                                    <div style="font-size: 0.72rem; color: var(--color-blue-primary); font-weight: 700; margin-top: 5px;">
                                        <i class="fa-solid fa-file-shield"></i> Berkas sudah terunggah di server
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- File 2: KTP -->
                        <div class="form-group">
                            <label>Foto Copy KTP <span>*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('ktp').click();">
                                <i class="fa-solid fa-id-card-clip" style="color: var(--color-yellow);"></i>
                                <h5>Klik / Seret Berkas KTP</h5>
                                <p>Format: PDF, JPG, PNG (Max 2MB)</p>
                                <input type="file" name="ktp" id="ktp" accept="image/*,.pdf" @if(!$registration) required @endif onchange="handleFileSelect(this, 'ktpPreview', 'ktpBadge')">
                                <span class="file-info-badge" id="ktpBadge">Berkas terpilih</span>
                                <img src="" class="file-preview" id="ktpPreview">
                                @if($registration?->ktp_path)
                                    <div style="font-size: 0.72rem; color: var(--color-blue-primary); font-weight: 700; margin-top: 5px;">
                                        <i class="fa-solid fa-file-shield"></i> Berkas sudah terunggah di server
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- File 3: KK -->
                        <div class="form-group">
                            <label>Foto Copy Kartu Keluarga (KK) <span>*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('kk').click();">
                                <i class="fa-solid fa-people-roof" style="color: var(--color-red);"></i>
                                <h5>Klik / Seret Berkas KK</h5>
                                <p>Format: PDF, JPG, PNG (Max 2MB)</p>
                                <input type="file" name="kk" id="kk" accept="image/*,.pdf" @if(!$registration) required @endif onchange="handleFileSelect(this, 'kkPreview', 'kkBadge')">
                                <span class="file-info-badge" id="kkBadge">Berkas terpilih</span>
                                <img src="" class="file-preview" id="kkPreview">
                                @if($registration?->kk_path)
                                    <div style="font-size: 0.72rem; color: var(--color-blue-primary); font-weight: 700; margin-top: 5px;">
                                        <i class="fa-solid fa-file-shield"></i> Berkas sudah terunggah di server
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- File 4: Pas Foto -->
                        <div class="form-group">
                            <label>Pas Foto Berwarna Uk. 3x4 <span>*</span></label>
                            <div class="upload-zone" onclick="document.getElementById('pas_foto').click();">
                                <i class="fa-solid fa-user-check" style="color: var(--color-blue-light);"></i>
                                <h5>Klik / Seret Pas Foto 3x4</h5>
                                <p>Format: JPG, PNG (Max 2MB)</p>
                                <input type="file" name="pas_foto" id="pas_foto" accept="image/*" @if(!$registration) required @endif onchange="handleFileSelect(this, 'pasFotoPreview', 'pasFotoBadge')">
                                <span class="file-info-badge" id="pasFotoBadge">Berkas terpilih</span>
                                <img src="" class="file-preview" id="pasFotoPreview">
                                @if($registration?->pas_foto_path)
                                    <div style="font-size: 0.72rem; color: var(--color-blue-primary); font-weight: 700; margin-top: 5px;">
                                        <i class="fa-solid fa-file-shield"></i> Berkas sudah terunggah di server
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PAYMENT BANK TRANSFER / QRIS -->
                <div class="form-step-content" data-step="3">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-money-bill-wave" style="color: var(--color-red);"></i> Tahap 3: Pembayaran Biaya Pendaftaran
                    </h4>

                    <div class="payment-wrapper">
                        <div>
                            <div style="background: rgba(29, 78, 216, 0.05); padding: 20px; border-radius: var(--radius-md); border-left: 5px solid var(--color-blue-primary); margin-bottom: 20px;">
                                <h5 style="font-weight: 800; color: var(--color-blue-dark); font-size: 0.95rem; margin-bottom: 5px;">Biaya Administrasi & Kelas:</h5>
                                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 10px;">Biaya pendaftaran dan pembelajaran untuk program yang dipilih:</p>
                                <div style="font-size: 1.6rem; font-weight: 900; color: var(--color-red);" id="priceTag">Rp 0</div>
                            </div>

                            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 20px;">
                                Pendaftaran online mewajibkan transfer ke rekening resmi bank LKP INKA atau menggunakan kode QRIS terintegrasi di samping untuk pembayaran instan non-tunai.
                            </p>

                            <!-- Optional Receipt Upload -->
                            <div class="form-group">
                                <label>Unggah Bukti Bayar <em>(Opsional untuk Mempercepat Verifikasi)</em></label>
                                <div class="upload-zone" onclick="document.getElementById('payment_receipt').click();" style="min-height: 120px; padding: 15px;">
                                    <i class="fa-solid fa-receipt" style="font-size: 1.8rem;"></i>
                                    <h5 style="font-size: 0.85rem; margin-bottom: 2px;">Klik untuk unggah Struk/Bukti Transfer</h5>
                                    <input type="file" name="payment_receipt" id="payment_receipt" accept="image/*,.pdf" onchange="handleFileSelect(this, 'receiptPreview', 'receiptBadge')">
                                    <span class="file-info-badge" id="receiptBadge">Berkas terpilih</span>
                                    <img src="" class="file-preview" id="receiptPreview">
                                    @if($registration?->payment_receipt_path)
                                        <div style="font-size: 0.72rem; color: var(--color-blue-primary); font-weight: 700; margin-top: 5px;">
                                            <i class="fa-solid fa-file-shield"></i> Bukti bayar sudah terunggah
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- BANK QRIS CARD -->
                        <div class="qris-card">
                            <div class="qris-logo"><span>Pembayaran</span></div>
                            <div class="bank-info-item">
                                <span>Bank Transfer</span>
                                <strong>BANK BRI</strong>
                            </div>
                            <div class="bank-info-item">
                                <span>No. Rekening</span>
                                <strong>1629-01-006722-53-0</strong>
                            </div>
                            <div class="bank-info-item" style="border-bottom: none;">
                                <span>Atas Nama</span>
                                <strong>LKP INKA</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: REVIEW DATA -->
                <div class="form-step-content" data-step="4">
                    <h4 style="font-weight: 800; font-size: 1.2rem; color: var(--color-blue-dark); margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">
                        <i class="fa-solid fa-clipboard-check" style="color: var(--color-blue-light);"></i> Tahap 4: Review Pendaftaran & Konfirmasi Akhir
                    </h4>

                    <div style="background: #f8fafc; padding: 25px; border-radius: var(--radius-md); border: 1px solid #e2e8f0; margin-bottom: 25px;">
                        <h5 style="font-weight: 800; color: var(--color-blue-dark); margin-bottom: 15px;">Rangkuman Data Registrasi:</h5>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 0.92rem;">
                            <div>
                                <span style="color: var(--text-muted);">Nama Lengkap:</span>
                                <div style="font-weight: 700; color: var(--color-blue-dark);" id="reviewNama">Budi Santoso</div>
                            </div>
                            <div>
                                <span style="color: var(--text-muted);">Program Kursus:</span>
                                <div style="font-weight: 700; color: var(--color-blue-primary);" id="reviewKursus">Komputer</div>
                            </div>
                            <div>
                                <span style="color: var(--text-muted);">No. HP (WhatsApp):</span>
                                <div style="font-weight: 700;" id="reviewHP">-</div>
                            </div>
                            <div>
                                <span style="color: var(--text-muted);">Alamat Email:</span>
                                <div style="font-weight: 700;" id="reviewEmail">-</div>
                            </div>
                            <div style="grid-column: span 2;">
                                <span style="color: var(--text-muted);">Alamat Tempat Tinggal:</span>
                                <div style="font-weight: 700; line-height: 1.4;" id="reviewAlamat">-</div>
                            </div>
                        </div>
                    </div>

                    <label style="display: flex; gap: 12px; font-size: 0.88rem; font-weight: 600; color: var(--text-primary); cursor: pointer; line-height: 1.5;">
                        <input type="checkbox" id="declarationCheck" required style="margin-top: 4px; accent-color: var(--color-blue-primary);">
                        <span>Saya menyatakan dengan sesungguhnya bahwa seluruh data yang diisi dan berkas dokumen yang diunggah di atas adalah benar milik saya, asli, dan sah secara hukum.</span>
                    </label>
                </div>

                <!-- FOOTER ACTIONS NAVIGATION -->
                <div style="display: flex; justify-content: space-between; margin-top: 40px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                    <button type="button" class="btn btn-secondary" id="btnBack" style="display: none;" onclick="navigateStep(-1)">
                        <i class="fa-solid fa-arrow-left"></i> Sebelumnya
                    </button>
                    
                    <button type="button" class="btn btn-primary" id="btnNext" style="margin-left: auto;" onclick="navigateStep(1)">
                        Berikutnya <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    
                    <button type="submit" class="btn btn-yellow" id="btnSubmit" style="margin-left: auto; display: none;">
                        <i class="fa-solid fa-circle-check"></i> {{ ($registration && $registration->status === 'pending') ? 'Perbarui Pendaftaran' : 'Kirim Pendaftaran' }}
                    </button>
                </div>
                
            </form>

        </div>
    </section>

@endsection

@section('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 4;

    // Handle File Select Previews
    function handleFileSelect(input, previewId, badgeId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        const badge = document.getElementById(badgeId);

        if (file) {
            badge.innerText = file.name.substring(0, 15) + (file.name.length > 15 ? '...' : '');
            badge.style.display = 'inline-block';

            // Show image preview if it's an image
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                // If it is a PDF or other file
                preview.style.display = 'none';
            }
        } else {
            badge.style.display = 'none';
            preview.style.display = 'none';
        }
    }

    // Dynamic Price Tag & Summary Loading on input
    function updateFormDetails() {
        const select = document.getElementById('course_id');
        const priceTag = document.getElementById('priceTag');
        const selectedOpt = select.options[select.selectedIndex];
        
        if (selectedOpt && select.value) {
            priceTag.innerText = selectedOpt.getAttribute('data-price');
            document.getElementById('reviewKursus').innerText = selectedOpt.text;
        } else {
            priceTag.innerText = 'Rp 0';
            document.getElementById('reviewKursus').innerText = '-- Belum Memilih Kursus --';
        }

        // Prefill Review
        document.getElementById('reviewNama').innerText = document.getElementById('nama_lengkap').value || '-';
        document.getElementById('reviewHP').innerText = document.getElementById('nomer_hp').value || '-';
        document.getElementById('reviewEmail').innerText = document.getElementById('email').value || '-';
        document.getElementById('reviewAlamat').innerText = document.getElementById('alamat').value || '-';
    }

    // Bind event listeners for real-time review updates
    document.getElementById('course_id').addEventListener('change', updateFormDetails);
    document.getElementById('nama_lengkap').addEventListener('input', updateFormDetails);
    document.getElementById('nomer_hp').addEventListener('input', updateFormDetails);
    document.getElementById('email').addEventListener('input', updateFormDetails);
    document.getElementById('alamat').addEventListener('input', updateFormDetails);

    // Multi-Step Form Navigation Logic
    function navigateStep(direction) {
        // Validate current step fields before going next
        if (direction === 1 && !validateCurrentStepFields()) {
            return; // block navigation if validation fails
        }

        currentStep += direction;
        if (currentStep < 1) currentStep = 1;
        if (currentStep > totalSteps) currentStep = totalSteps;

        updateStepVisuals();
    }

    function validateCurrentStepFields() {
        const activeContent = document.querySelector(`.form-step-content[data-step="${currentStep}"]`);
        const requiredFields = activeContent.querySelectorAll('[required]');
        
        let valid = true;
        requiredFields.forEach(field => {
            if (!field.value) {
                field.style.borderColor = 'var(--color-red)';
                valid = false;
            } else {
                field.style.borderColor = '#cbd5e1';
            }
        });

        if (!valid) {
            showToast('Mohon lengkapi seluruh field bertanda bintang wajib (*) sebelum melanjutkan.', 'warning');
        }
        return valid;
    }

    function updateStepVisuals() {
        // Hide all step contents, show current
        document.querySelectorAll('.form-step-content').forEach(el => el.classList.remove('active'));
        document.querySelector(`.form-step-content[data-step="${currentStep}"]`).classList.add('active');

        // Update step nodes indicator
        document.querySelectorAll('.step-node').forEach(node => {
            const stepNum = parseInt(node.getAttribute('data-step'));
            node.classList.remove('active', 'completed');
            if (stepNum === currentStep) {
                node.classList.add('active');
            } else if (stepNum < currentStep) {
                node.classList.add('completed');
            }
        });

        // Update step progress bar width
        const progressPercent = ((currentStep - 1) / (totalSteps - 1)) * 90;
        document.getElementById('stepProgressBar').style.width = `${progressPercent}%`;

        // Update Back and Next / Submit buttons display
        const btnBack = document.getElementById('btnBack');
        const btnNext = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');

        if (currentStep === 1) {
            btnBack.style.display = 'none';
        } else {
            btnBack.style.display = 'inline-flex';
        }

        if (currentStep === totalSteps) {
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'inline-flex';
            updateFormDetails(); // Load final review data
        } else {
            btnNext.style.display = 'inline-flex';
            btnSubmit.style.display = 'none';
        }
    }

    // On Load Initializations
    window.addEventListener('load', () => {
        updateStepVisuals();
        updateFormDetails();

        // Form submit validator
        document.getElementById('regForm').addEventListener('submit', (e) => {
            const decCheck = document.getElementById('declarationCheck');
            if (!decCheck.checked) {
                e.preventDefault();
                showToast('Anda harus menyetujui pernyataan deklarasi kebenaran berkas pendaftaran.', 'warning');
            }
        });
    });
</script>
@endsection
