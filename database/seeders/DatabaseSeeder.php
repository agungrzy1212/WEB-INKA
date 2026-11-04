<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin and a Student)
        User::firstOrCreate(
            ['email' => 'admin@lkpinka.com'],
            [
                'name' => 'Administrator INKA',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'budi@example.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );

        // 2. Seed Courses (All 24 courses specified)
        $courses = [
            // Kategori Komputer
            [
                'name' => 'PROGRAM KOMPUTER (MS-OFFICE PROFESIONAL)',
                'category' => 'Komputer',
                'description' => 'Pelatihan intensif menguasai program perkantoran Microsoft Office (Word, Excel, PowerPoint) tingkat mahir untuk kebutuhan administrasi profesional.',
                'price' => 750000,
                'duration' => '1.5 Bulan',
            ],
            [
                'name' => 'PROGRAM KOMPUTER (DESAIN GRAFIS)',
                'category' => 'Komputer',
                'description' => 'Kuasai software pengolah grafis terpopuler (Photoshop, CorelDRAW, Illustrator) untuk karir desainer grafis kreatif.',
                'price' => 950000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'INTERNET MARKETING (E-COMMERCE)',
                'category' => 'Komputer',
                'description' => 'Strategi sukses jualan online, pemasaran digital, periklanan media sosial (Meta Ads, Google Ads), serta manajemen toko online.',
                'price' => 1200000,
                'duration' => '1 Bulan',
            ],

            // Kategori Mengemudi
            [
                'name' => 'MENGEMUDI MOBIL (PAKET HEMAT)',
                'category' => 'Mengemudi',
                'description' => 'Paket belajar dasar mengemudi mobil manual sebanyak 6 kali pertemuan secara privat.',
                'price' => 450000,
                'duration' => '2 Minggu',
            ],
            [
                'name' => 'MENGEMUDI MOBIL (PAKET STANDAR)',
                'category' => 'Mengemudi',
                'description' => 'Paket lengkap belajar mengemudi mobil manual dengan materi dasar, tanjakan, parkir, dan jalan raya (10 kali pertemuan).',
                'price' => 700000,
                'duration' => '3 Minggu',
            ],
            [
                'name' => 'MENGEMUDI MOBIL (PAKET TERAMPIL)',
                'category' => 'Mengemudi',
                'description' => 'Paket mendalam belajar mobil manual/matic untuk persiapan mahir di jalan raya macet dan parkir area sempit (14 kali pertemuan).',
                'price' => 950000,
                'duration' => '4 Minggu',
            ],
            [
                'name' => 'MENGEMUDI MOBIL (PAKET PROFESIONAL)',
                'category' => 'Mengemudi',
                'description' => 'Paket premium penguasaan mengemudi di segala medan jalan, berkendara malam hari, serta bimbingan pembuatan SIM A.',
                'price' => 1300000,
                'duration' => '5 Minggu',
            ],
            [
                'name' => 'MENGEMUDI SEPEDA MOTOR',
                'category' => 'Mengemudi',
                'description' => 'Pelatihan privat mengendarai sepeda motor matic dan manual (kopling) untuk pemula dengan aman dan benar.',
                'price' => 350000,
                'duration' => '1 Minggu',
            ],

            // Kategori Otomotif
            [
                'name' => 'OTOMOTIF/BENGKEL SEPEDA MOTOR',
                'category' => 'Otomotif',
                'description' => 'Pelatihan mekanik sepeda motor tingkat dasar hingga lanjut, mendeteksi kerusakan mesin (troubleshooting) dan sistem kelistrikan.',
                'price' => 1800000,
                'duration' => '3 Bulan',
            ],
            [
                'name' => 'OTOMOTIF/BENGKEL MOBIL',
                'category' => 'Otomotif',
                'description' => 'Pelatihan montir mobil komprehensif meliput mesin, sistem transmisi, rem, kaki-kaki mobil, dan kelistrikan mobil.',
                'price' => 2500000,
                'duration' => '3 Bulan',
            ],

            // Kategori Menjahit & Bordir
            [
                'name' => 'MENJAHIT (TINGKAT DASAR I & II)',
                'category' => 'Menjahit',
                'description' => 'Belajar teknik dasar mengukur, memotong pola, mengoperasikan mesin jahit, hingga membuat pakaian sederhana.',
                'price' => 1200000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'MENJAHIT (TINGKAT TERAMPIL)',
                'category' => 'Menjahit',
                'description' => 'Teknik menjahit pakaian wanita modern, gaun pesta, jas, celana formal, serta variasi kerah dan lengan tingkat lanjut.',
                'price' => 1500000,
                'duration' => '2.5 Bulan',
            ],
            [
                'name' => 'BORDIR',
                'category' => 'Menjahit',
                'description' => 'Pelatihan teknik bordir manual dan bordir komputer/mesin pada berbagai jenis kain untuk keperluan usaha konveksi.',
                'price' => 850000,
                'duration' => '1.5 Bulan',
            ],
            [
                'name' => 'KERAJINAN TANGAN (HANDYCRAFT)',
                'category' => 'Kerajinan',
                'description' => 'Belajar membuat aneka kerajinan tangan bernilai ekonomi tinggi seperti rajutan, sulaman, aksesoris manik, dan olahan bahan limbah.',
                'price' => 600000,
                'duration' => '1 Bulan',
            ],

            // Kategori Bahasa Inggris
            [
                'name' => 'BAHASA INGGRIS (Elementary)',
                'category' => 'Bahasa Inggris',
                'description' => 'Penguasaan kosakata dasar, struktur tata bahasa (grammar) pemula, dan latihan percakapan sehari-hari yang sederhana.',
                'price' => 500000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'BAHASA INGGRIS (Intermediate)',
                'category' => 'Bahasa Inggris',
                'description' => 'Meningkatkan kemampuan menulis, membaca, mendengarkan, serta berdiskusi aktif menggunakan tata bahasa tingkat menengah.',
                'price' => 600000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'BAHASA INGGRIS (Advance)',
                'category' => 'Bahasa Inggris',
                'description' => 'Program bahasa Inggris tingkat mahir untuk keperluan presentasi, menulis esai akademik, dan diskusi isu-isu kompleks.',
                'price' => 700000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'BAHASA INGGRIS (Conversation)',
                'category' => 'Bahasa Inggris',
                'description' => 'Fokus penuh pada kelancaran berbicara (fluency), pelafalan (pronunciation), dan kepercayaan diri saat berinteraksi sosial/bisnis.',
                'price' => 550000,
                'duration' => '1.5 Bulan',
            ],
            [
                'name' => 'BAHASA INGGRIS (TOEFL)',
                'category' => 'Bahasa Inggris',
                'description' => 'Persiapan intensif menghadapi tes TOEFL, meliput Listening, Structure, Reading Comprehension, serta tips dan trik meraih skor tinggi.',
                'price' => 850000,
                'duration' => '1.5 Bulan',
            ],

            // Kategori Bahasa Asing
            [
                'name' => 'BHS. ASING (JEPANG/KOREA/MANDARIN)',
                'category' => 'Bahasa Asing',
                'description' => 'Pelatihan bahasa asing dasar untuk persiapan bekerja ke luar negeri atau kebutuhan akademik (pilih salah satu bahasa saat pendaftaran).',
                'price' => 1500000,
                'duration' => '3 Bulan',
            ],

            // Kategori Kecantikan & Rias
            [
                'name' => 'TATA KECANTIKAN RAMBUT DAN WAJAH (SALON)',
                'category' => 'Kecantikan',
                'description' => 'Teknik memotong rambut, creambath, pewarnaan, facial, perawatan wajah, serta riasan salon sehari-hari.',
                'price' => 1800000,
                'duration' => '2 Bulan',
            ],
            [
                'name' => 'TATA RIAS PENGANTIN',
                'category' => 'Kecantikan',
                'description' => 'Seni merias wajah pengantin adat (Solo, Yogyakarta, Sunda) dan gaya modern, serta teknik memasang sanggul/hijab pengantin.',
                'price' => 2000000,
                'duration' => '2 Bulan',
            ],

            // Kategori Elektro
            [
                'name' => 'ELEKTRO/SERVICE HANDPHONE',
                'category' => 'Elektro',
                'description' => 'Pelatihan perbaikan perangkat keras (hardware) dan lunak (software) HP, teknik solder, ganti LCD, serta flashing OS.',
                'price' => 1600000,
                'duration' => '2 Bulan',
            ],

            // Kategori Spa & Massage
            [
                'name' => 'SPA/MASSAGE',
                'category' => 'Spa',
                'description' => 'Keterampilan terapi pijat tradisional, refleksiologi, aromaterapi, lulur badan, dan perawatan relaksasi profesional standar salon/hotel.',
                'price' => 1400000,
                'duration' => '1.5 Bulan',
            ],
        ];

        foreach ($courses as $c) {
            Course::firstOrCreate(['name' => $c['name']], $c);
        }

        // 3. Seed News (Default articles)
        News::firstOrCreate(
            ['title' => 'Pendaftaran Gelombang Baru LKP INKA Wonosobo Resmi Dibuka!'],
            ['content' => "Kabar gembira bagi masyarakat Wonosobo dan sekitarnya! Lembaga Kursus dan Pelatihan (LKP) INKA Wonosobo kembali membuka pendaftaran calon peserta didik baru untuk seluruh program keahlian di Gelombang ini. Dapatkan kesempatan belajar dibimbing instruktur bersertifikasi industri dengan biaya terjangkau.\n\nPendaftaran dapat dilakukan secara online melalui website resmi ini dengan mengisi formulir pendaftaran, mengunggah berkas yang dipersyaratkan (Ijazah, KTP, KK, dan Pas Foto), serta melampirkan bukti pembayaran pendaftaran.\n\nJangan lewatkan kesempatan emas untuk memperkaya keterampilan kerja Anda demi masa depan yang lebih mapan!"]
        );

        News::firstOrCreate(
            ['title' => 'LKP INKA Wonosobo Meraih Akreditasi Unggul Tahun Ini'],
            ['content' => "Prestasi membanggakan kembali diukir oleh LKP INKA Wonosobo. Tahun ini, lembaga kami resmi menyandang predikat Akreditasi Unggul dari Badan Akreditasi Nasional. Penghargaan ini menjadi bukti komitmen LKP INKA dalam mempertahankan kualitas pembelajaran, keandalan fasilitas, dan tingkat keberhasilan kelulusan alumni yang sangat tinggi.\n\nPimpinan LKP INKA Wonosobo menyampaikan rasa terima kasih yang sebesar-besarnya kepada seluruh instruktur, staf pendukung, alumni, dan para mitra industri yang telah berkontribusi besar dalam pencapaian luar biasa ini. LKP INKA berkomitmen untuk terus meningkatkan pelayanan pendidikan non-formal bagi masyarakat."]
        );

        News::firstOrCreate(
            ['title' => 'Tips Sukses Memilih Program Kursus yang Sesuai dengan Minat Anda'],
            ['content' => "Memilih program kursus seringkali membingungkan mengingat banyaknya pilihan keahlian yang menarik. Berikut adalah beberapa panduan praktis dari instruktur senior LKP INKA Wonosobo untuk membantu Anda menentukan pilihan:\n\n1. Pahami Minat Utama Anda: Apakah Anda lebih menyukai pekerjaan berbasis teknologi (komputer/desain), kegiatan motorik/praktis (mengemudi/otomotif), bidang bahasa, atau industri estetika (kecantikan/spa)?\n2. Tinjau Kebutuhan Pasar Kerja: Pelajari keterampilan apa saja yang sedang tinggi permintaannya di Wonosobo atau kota besar lainnya.\n3. Rencana Karir Masa Depan: Apakah Anda ingin menjadi wirausahawan mandiri (seperti membuka bengkel atau salon) atau bekerja di perkantoran?\n\nKombinasikan faktor minat dan peluang karir di atas agar program yang Anda ambil membuahkan kesuksesan jangka panjang!"]
        );

        // 4. Seed Site Settings (Dynamic Contents)
        SiteSetting::setValue('home_hero_title', 'Sistem Informasi Pendaftaran Kursus LKP INKA Wonosobo');
        SiteSetting::setValue('home_hero_subtitle', 'Raih Keahlian Profesional dan Masa Depan Gemilang Bersama Lembaga Pelatihan Terakreditasi di Wonosobo.');
        SiteSetting::setValue('home_cta_text', 'Daftar Kursus Sekarang');
        SiteSetting::setValue('profil_about', 'LKP INKA (Lembaga Kursus dan Pelatihan INKA) Wonosobo merupakan pusat pelatihan keterampilan kerja terpercaya yang telah membantu ribuan alumni sukses berwirausaha maupun bekerja di industri kreatif dan profesional. Kami berdedikasi tinggi untuk mencerdaskan masyarakat melalui berbagai program kursus yang relevan dengan perkembangan industri terkini.');
        SiteSetting::setValue('profil_visi', 'Menjadi Lembaga Kursus dan Pelatihan terkemuka di Wonosobo yang menghasilkan sumber daya manusia berkarakter unggul, kompeten, kreatif, mandiri, dan berdaya saing global.');
        SiteSetting::setValue('profil_misi', "1. Menyelenggarakan pelatihan kerja yang inovatif berbasis kompetensi.\n2. Menyediakan sarana dan fasilitas pembelajaran yang modern dan lengkap.\n3. Menjalin kemitraan dengan industri untuk penyaluran lulusan kursus.\n4. Membimbing alumni menjadi wirausahawan mandiri yang sukses.");
    }
}
