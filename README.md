# 🎓 SIPKL - Sistem Informasi & Portal Monitoring Praktek Kerja Lapangan

![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-3.x-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![Vue.js 3](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-4.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![SOLID Architecture](https://img.shields.io/badge/Architecture-SOLID_Principles-0052CC?style=for-the-badge)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**SIPKL (Sistem Informasi Praktek Kerja Lapangan)** adalah platform digital modern terpadu berbasis **Laravel 12** dan **Inertia.js Vue 3** yang dirancang untuk mempermudah monitoring kehadiran presisi, pencatatan jurnal kegiatan harian, evaluasi nilai siswa, serta pengelolaan konten landing page secara fleksibel (CMS).

Projek ini dibangun secara ketat menerapkan **Arsitektur SOLID Principles**, **Clean Code**, **Composite Indexing**, dan **Serverless Ready** di Vercel.

---

## 🌐 Demo & Tautan Live

* **Production URL**: [https://pkl-dev.vercel.app](https://pkl-dev.vercel.app)
* **Halaman Login**: [https://pkl-dev.vercel.app/login](https://pkl-dev.vercel.app/login)
* **Halaman Register**: [https://pkl-dev.vercel.app/register](https://pkl-dev.vercel.app/register)

---

## 🔐 Akun & Kredensial Default (Development)

| Role | Email / Username | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@pkl.com` (`admin`) | `AdminPkl#Dev2026` | Akses penuh dashboard admin & CMS |
| **Siswa PKL** | `afdanu@gmail.com` (`afdanu`) | `AfdanuPkl#Dev2026` | Akun siswa status approved |

---

## ✨ Fitur Utama

### 1. 🌐 Landing Page Publik Dinamis (Cerah & Interaktif)
* **Beranda (Hero Banner)**: Headline, subjudul dinamis, badge pengumuman, dan CTA langsung ke login portal.
* **Tentang Kami**: Profil program PKL, visi, misi, dan counter statistik siswa/sekolah/divisi.
* **Alumni Showcase**: Card portrait dengan foto penuh, badge tim divisi, nama besar, dan asal sekolah.
* **Galeri Dokumentasi**: Grid foto dokumentasi kegiatan dengan filter kategori (*Orientasi*, *Kegiatan*, *Evaluasi*).
* **Prosedur & Alur**: Timeline 5 langkah sistematis pelaksanaan magang.
* **Hubungi Kami**: Alamat pusat, kontak WhatsApp, email, dan card direct login.

### 2. 🔑 Otentikasi & Registrasi Minimalis
* **Clean & Minimalist Light Theme**: Desain kartu putih bersih dengan aksen biru brand (`rgb(93, 135, 255)`).
* **Fitur Login**: Toggle visibility password (Eye/EyeOff), remember me, pesan validasi responsif.
* **Pendaftaran Siswa Multi-Step**: Wizard 2-tahap (1. Akun & Kontak, 2. Data Akademik & Upload CV format PDF maksimal 5MB).
* **Brute-force Rate Limiting**: Batasan percobaan request login (`throttle:5,1`) dan register (`throttle:10,1`).

### 3. 👨‍🎓 Portal Siswa PKL
* **Dashboard Interaktif**: Status absensi hari ini, ringkasan jurnal yang disetujui, dan pengumuman broadcast.
* **Absensi 1-Klik**: Pencatatan otomatis jam masuk dan pulang sesuai batasan window waktu operasional real-time.
* **Jurnal Kegiatan Digital**: Input log harian lengkap dengan upload bukti foto/dokumen pengerjaan tugas.
* **Pengajuan Izin / Sakit**: Formulir pengajuan izin/sakit beserta upload lampiran surat dokter/keterangan.
* **Jadwal & Laporan Piket**: Cek jadwal shift piket mingguan dan submit foto laporan piket harian.

### 4. 🛡️ Portal Administrator (Manajemen Penuh & CMS)
* **Approval Pendaftaran Siswa**: Tinjau data pendaftar baru, verifikasi berkas CV PDF, serta persetujuan (Approve/Reject).
* **Manajemen Data Siswa**: Kelola data siswa aktif, ubah sesi kerja (*full day / per sesi*), dan penempatan divisi.
* **Rekap Jurnal & Absensi Terpisah**: Pantau dan verifikasi jurnal serta absensi seluruh siswa secara harian.
* **Presensi Manual**: Fasilitas pencatatan absensi manual siswa oleh admin jika ada kendala sistem.
* **Master Data**: Kelola Data Sekolah, Jurusan, Divisi Kerja, Gelombang (Batch) PKL, dan Pembimbing Instansi.
* **Penilaian & Sertifikat**: Input rubrik nilai kedisiplinan, teknis, jurnal, presisi absensi, dan sikap (kalkulasi nilai & grade otomatis).
* **Jam Operasional**: Atur batasan jam buka/tutup pengisian jurnal dan window waktu tombol absensi masuk/pulang.
* **Editor Landing Page CMS**: Kelola teks seksi, kontak, testimoni alumni, galeri foto, dan langkah prosedur secara live tanpa menyentuh kode.

---

## 🏛️ Arsitektur Backend: Penerapan SOLID Principles

Aplikasi ini menggunakan arsitektur 4-layer yang memisahkan tanggung jawab secara ketat:

```
[ HTTP Request ] 
       │
       ▼
[ Form Request Layer ]   --> (app/Http/Requests/*) : Isolasi Validasi & Otorisasi
       │
       ▼
[ Controller Layer ]     --> (app/Http/Controllers/*) : Thin Controller (HTTP Response & Inertia::render)
       │
       ▼
[ Service Layer ]        --> (app/Services/*) : Logika Bisnis & Perhitungan
       │
       ▼
[ Repository Layer ]     --> (app/Repositories/*) : Query Database, Caching & Data Aggregation
       │
       ▼
[ Resource Layer ]       --> (app/Http/Resources/*) : Transformasi Data JSON Konsisten
```

1. **Single Responsibility Principle (SRP)**: Controller, Form Request, Service, Repository, dan Resource masing-masing hanya memiliki satu tanggung jawab tunggal.
2. **Open/Closed Principle (OCP)**: Seluruh Service dan Repository mengimplementasikan Interface/Contract (`app/Contracts/*`), mempermudah pergantian implementasi (misal database/storage driver) tanpa merusak kode lama.
3. **Liskov Substitution Principle (LSP)**: Kelas konkret mematuhi kontrak antarmuka secara presisi.
4. **Interface Segregation Principle (ISP)**: Interface dipecah granular per-domain model (`UserRepositoryInterface`, `JournalRepositoryInterface`, `AttendanceRepositoryInterface`, dll.).
5. **Dependency Inversion Principle (DIP)**: Controller dan Service hanya bergantung pada abstraksi (*Interfaces*), yang di-bind secara otomatis pada `AppServiceProvider`.

---

## 🚀 Panduan Instalasi Lokal

### Prasyarat
* **PHP** >= 8.2 (disarankan PHP 8.3 / 8.4) dengan ekstensi `pdo_sqlite`, `mbstring`, `openssl`
* **Composer** >= 2.x
* **Node.js** >= 20.x & **NPM**

### Langkah Instalasi
1. **Clone Repository**:
   ```bash
   git clone https://github.com/danu-dev/pkl-dev.git
   cd pkl-dev
   ```

2. **Install Dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Seeder**:
   ```bash
   touch database/database.sqlite
   php artisan migrate:refresh --seed
   php artisan db:seed --class=LandingPageSeeder
   ```

5. **Generate TypeScript Routes & Storage Link**:
   ```bash
   php artisan wayfinder:generate
   php artisan storage:link
   ```

6. **Menjalankan Server**:
   Jalankan frontend build watcher dan server Laravel secara bersamaan:
   ```bash
   # Terminal 1
   npm run dev

   # Terminal 2
   php artisan serve
   ```
   Buka browser di `http://localhost:8000`.

---

## 🧪 Testing & Code Quality

Projek ini dilengkapi dengan automated testing menggunakan **Pest PHP** dan code formatting standar **Laravel Pint**:

```bash
# Menjalankan seluruh Test Suite
php artisan test --compact

# Menjalankan Code Formatter (Laravel Pint)
vendor/bin/pint --dirty --format agent

# Build Asset Produksi
npm run build
```

---

## 📄 Lisensi

Projek ini dirilis di bawah lisensi [MIT License](LICENSE).
