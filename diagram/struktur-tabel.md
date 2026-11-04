# Struktur Tabel Database - WEB INKA

Berikut adalah detail struktur tabel dari database berdasarkan skema migrations Laravel:

## 1. Tabel `users`
Digunakan untuk menyimpan data pengguna (siswa, admin, dll).

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `name` | VARCHAR | Nama Pengguna |
| `email` | VARCHAR | Email Pengguna, Unique |
| `email_verified_at` | TIMESTAMP | Waktu verifikasi email (Nullable) |
| `password` | VARCHAR | Password Hashed |
| `role` | VARCHAR | Peran pengguna (default: 'siswa') |
| `remember_token` | VARCHAR | Token untuk fitur remember me |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

## 2. Tabel `courses`
Digunakan untuk menyimpan informasi program kursus yang tersedia.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `name` | VARCHAR | Nama Kursus |
| `category` | VARCHAR | Kategori Kursus |
| `description` | TEXT | Deskripsi Kursus (Nullable) |
| `price` | INTEGER | Harga Kursus (default: 0) |
| `duration` | VARCHAR | Durasi Kursus (Nullable) |
| `image` | VARCHAR | Path file gambar kursus (Nullable) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

## 3. Tabel `registrations`
Digunakan untuk menyimpan data pendaftaran siswa ke suatu kursus.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `user_id` | BIGINT | Foreign Key ke tabel `users` (Cascade Delete) |
| `course_id` | BIGINT | Foreign Key ke tabel `courses` (Cascade Delete) |
| `nama_lengkap` | VARCHAR | Nama lengkap pendaftar |
| `tanggal_lahir` | DATE | Tanggal lahir pendaftar |
| `alamat` | TEXT | Alamat domisili |
| `nomer_hp` | VARCHAR | Nomor Handphone |
| `email` | VARCHAR | Email pendaftar |
| `ijazah_path` | VARCHAR | Path file upload ijazah |
| `ktp_path` | VARCHAR | Path file upload KTP |
| `kk_path` | VARCHAR | Path file upload Kartu Keluarga |
| `pas_foto_path` | VARCHAR | Path file upload Pas Foto |
| `payment_receipt_path` | VARCHAR | Path bukti pembayaran (Nullable) |
| `status` | VARCHAR | Status pendaftaran (pending, approved, rejected) |
| `admin_notes` | TEXT | Catatan evaluasi dari admin (Nullable) |
| `course_name` | VARCHAR | Nama kursus saat pendaftaran dilakukan |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

## 4. Tabel `news`
Digunakan untuk menyimpan berita, pengumuman, atau artikel.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `title` | VARCHAR | Judul Berita |
| `content` | TEXT | Konten lengkap Berita |
| `image_path` | VARCHAR | Path file gambar berita (Nullable) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

## 5. Tabel `site_settings`
Digunakan untuk menyimpan konfigurasi atau pengaturan website (seperti Sejarah Singkat, dll).

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `key` | VARCHAR | Kunci pengaturan, Unique |
| `value` | TEXT | Nilai dari pengaturan (Nullable) |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |

## 6. Tabel `gallery_images`
Digunakan untuk menyimpan gambar-gambar galeri dokumentasi kegiatan.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | BIGINT | Primary Key, Auto Increment |
| `title` | VARCHAR | Judul Gambar (Nullable) |
| `image_path` | VARCHAR | Path file gambar |
| `created_at` | TIMESTAMP | Waktu dibuat |
| `updated_at` | TIMESTAMP | Waktu diupdate |
