<laravel-boost-guidelines>
# Laravel Application

This repository contains a Laravel application. Complete the following setup before working on the user's request.

## Prerequisites

Verify that PHP and Composer are available:

```sh
php -v
composer -V
```

If either command is unavailable, detect the user's operating system and install the prerequisites with the appropriate command:

macOS:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.5)"
```

Windows PowerShell:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.5'))
```

Linux:

```sh
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.5)"
```

After installation, ask the user to restart their terminal. If the agent needs the restarted shell to continue, ask the user to reopen their terminal and rerun their original prompt.

## Agent Setup

Install Laravel Boost from the application root before making application changes:

```sh
composer require laravel/boost --dev
php artisan boost:install
```

Boost replaces these bootstrap instructions with guidelines tailored to the application. After installation, read `AGENTS.md` again and continue with the user's original request using the generated guidelines.
</laravel-boost-guidelines>

# Product Requirements Document (PRD)
## Sistem CV Builder Terintegrasi AI — SMK Informatika Pesat

| | |
|---|---|
| Klien | Raenal Apriansyah, S.Kom — Guru Produktif DKV & Wakasek Hubungan Industri |
| Unit | SMK Informatika Pesat |
| Tim Pengembang | Abbad, Alief, Hanif, Salman, Syafiq |
| Status | Draft |

---

## 1. Latar Belakang

SMK Pesat menghadapi lima masalah operasional di area kesiswaan dan hubungan industri:

1. Tidak ada data alumni yang terstruktur; data alumni dua tahun terakhir hilang.
2. Belum ada katalog yang menghubungkan siswa dengan project industri yang butuh bantuan.
3. CV siswa dibuat lewat CV Kinobi (pihak ketiga), tanpa analisis kelemahan berbasis AI.
4. Lamaran kelas bekerja didata manual lewat spreadsheet, tanpa portal input atau analisis.
5. Tidak ada platform terpusat untuk informasi lowongan kerja mitra industri.

Masalah 3, 4, dan 5 digabung menjadi satu platform karena saling terkait dalam alur siswa mencari dan melamar kerja. Masalah 1 (data alumni) dan masalah 2 (katalog project, simulasi wawancara AI) berada di luar cakupan rilis ini — lihat bagian 5.

## 2. Tujuan Produk

- Mengganti CV Kinobi dengan CV builder internal yang terintegrasi AI untuk analisis kelemahan CV.
- Menggantikan pencatatan lamaran kelas bekerja berbasis spreadsheet dengan portal input digital.
- Memberi sekolah data lamaran siswa yang bisa dianalisis AI untuk pengambilan keputusan oleh admin/wakasek.
- Mendigitalkan pendataan alumni yang sebelumnya tidak tercatat sama sekali.
- Menyediakan satu sumber informasi lowongan kerja dari industri mitra.

## 3. Target Pengguna

| Role | Deskripsi | Kebutuhan utama |
|---|---|---|
| Siswa | Siswa aktif kelas bekerja | Membuat CV, melamar kerja, melacak status lamaran |
| Alumni | Lulusan SMK Pesat | Mengisi data diri pasca-kelulusan |
| Admin/Wakasek | Pengelola data kesiswaan dan hubungan industri | Memonitor lamaran, data alumni, dan hasil analisis AI |

Sistem membutuhkan pembedaan role saat registrasi (siswa/alumni) karena alur dan form yang diisi berbeda. Ini tidak eksplisit di backlog asli tapi wajib secara teknis — ditandai *[tambahan]* di bawah.

## 4. Ruang Lingkup

### 4.1 Masuk cakupan

- Autentikasi (register, login) untuk siswa dan admin, dengan akses berbasis role.
- CV Builder dengan template, manajemen sertifikat, multi-CV, riwayat CV.
- Analisis CV oleh AI (identifikasi kelemahan).
- Form data diri alumni dan dashboard rekap alumni untuk admin.
- Daftar lowongan kerja industri mitra (CRUD oleh admin, lihat-dan-lamar oleh siswa).
- Input dan pelacakan status lamaran kelas bekerja oleh siswa.
- Dashboard admin untuk monitoring data lamaran (job tracker).
- Analisis data lamaran oleh AI untuk admin.

### 4.2 Di luar cakupan (rilis ini)

- Katalog project industri untuk siswa (masalah #2 pada bagian 1).
- Simulasi wawancara kerja berbasis AI (masalah #6 pada bagian 1).
- Integrasi pembayaran atau sertifikasi resmi.

## 5. Daftar Fitur & Functional Requirements

### 5.1 Autentikasi & Akses
- Register dan login siswa, dengan pemilihan status siswa aktif atau alumni. *[tambahan]*
- Login admin dengan akses dashboard terpisah.
- Pembatasan akses berbasis role (siswa tidak bisa mengakses rute admin). *[tambahan]*
- Halaman profil siswa (data pendidikan, pengalaman, skill) sebagai sumber data CV dan analisis AI. *[tambahan — tanpa ini, CV Builder dan analisis AI tidak punya data untuk diproses]*

### 5.2 CV Builder
- Pembuatan CV dengan input data siswa.
- Pemilihan template CV.
- Penambahan sertifikat ke CV.
- Multi-CV per siswa.
- Riwayat CV yang pernah dibuat.
- Analisis CV oleh AI (kelemahan CV).
- Export CV ke PDF. *[tambahan — CV yang tidak bisa diunduh tidak bisa dipakai melamar kerja di luar sistem]*

### 5.3 Alumni
- Form pengisian data diri alumni.
- Dashboard rekap data alumni untuk admin/wakasek.

### 5.4 Lowongan Kerja & Lamaran
- CRUD lowongan kerja oleh admin. *[tambahan — item backlog #13 hanya mencakup sisi tampil ke siswa, tanpa ini daftar lowongan tidak pernah terisi]*
- Daftar lowongan kerja untuk siswa.
- Input lamaran kelas bekerja oleh siswa.
- Pelacakan status lamaran oleh siswa (diproses, wawancara, diterima, ditolak).
- Dashboard admin untuk monitoring data lamaran (job tracker, CRUD).
- Analisis data lamaran oleh AI untuk kesimpulan per siswa.

## 6. User Stories

| ID | User Story | Prioritas | Estimasi |
|---|---|---|---|
| US-01 | Sebagai siswa, saya ingin register dan login agar dapat menggunakan platform. | Tinggi | 1 hari |
| US-02 | Sebagai admin, saya ingin login agar dapat masuk ke dashboard admin. | Tinggi | 1 hari |
| US-03 | Sebagai siswa, saya ingin mengisi profil data diri sebagai sumber data CV. | Tinggi | 1 hari |
| US-04 | Sebagai siswa, saya ingin menggunakan fitur CV Builder. | Tinggi | 2 hari |
| US-05 | Sebagai siswa, saya ingin CV saya dianalisis AI untuk mengetahui kelemahannya. | Tinggi | 3–4 hari |
| US-06 | Sebagai siswa, saya ingin memilih template CV agar terlihat menarik. | Tinggi | 2 hari |
| US-07 | Sebagai pengguna, saya ingin menambahkan sertifikat ke CV. | Tinggi | 2 hari |
| US-08 | Sebagai pengguna, saya ingin mengunduh CV dalam bentuk PDF. | Tinggi | 1 hari |
| US-09 | Sebagai admin, saya ingin dashboard monitoring data lamaran (job tracker). | Sedang | 2 hari |
| US-10 | Sebagai pengguna, saya ingin membuat lebih dari satu CV untuk pekerjaan berbeda. | Sedang | 3 hari |
| US-11 | Sebagai siswa, saya ingin menginputkan data lamaran pekerjaan. | Sedang | 2 hari |
| US-12 | Sebagai pengguna, saya ingin melihat riwayat CV yang pernah dibuat. | Sedang | 1 hari |
| US-13 | Sebagai alumni, saya ingin mengisi data diri agar data kelulusan saya tercatat. | Tinggi | 2 hari |
| US-14 | Sebagai admin/wakasek, saya ingin melihat rekap data alumni dalam dashboard. | Tinggi | 1 hari |
| US-15 | Sebagai admin, saya ingin CRUD lowongan kerja industri mitra. | Tinggi | 2 hari |
| US-16 | Sebagai siswa, saya ingin melihat daftar lowongan kerja industri mitra. | Tinggi | 3 hari |
| US-17 | Sebagai siswa, saya ingin melacak status lamaran saya (diproses, wawancara, diterima, ditolak). | Tinggi | 2 hari |
| US-18 | Sebagai admin, saya ingin menganalisis data lamaran siswa dengan AI untuk mendapatkan kesimpulan. | Sedang | 2 hari |

## 7. Kebutuhan Non-Fungsional

*Bagian ini adalah asumsi standar untuk proyek sekolah, bukan permintaan eksplisit klien — perlu dikonfirmasi ulang dengan klien sebelum development.*

- Aplikasi web, responsif untuk akses dari laptop dan HP.
- Waktu respons analisis AI maksimum 10 detik per permintaan, dengan indikator loading.
- Data siswa dan alumni hanya bisa diakses oleh pemilik akun dan admin.
- Backup data lamaran dan CV minimum mingguan.

## 8. Asumsi & Batasan

- Analisis AI (CV dan lamaran) menggunakan API pihak ketiga; biaya dan rate limit perlu dikonfirmasi sebelum sprint fitur AI dimulai.
- Data alumni lama (2 tahun ke belakang) tidak bisa dimigrasikan otomatis karena tidak ada sumber data digital — pengisian ulang manual oleh alumni atau sekolah.
- Export CV diasumsikan format PDF saja pada rilis ini.

## 9. Rencana Sprint (Rilis Pertama)

| No | Tugas | Estimasi | PIC |
|---|---|---|---|
| 1 | Desain halaman register & login | 1 hari | Abbad |
| 2 | Fitur register siswa (dengan status siswa/alumni) | 1 hari | Abbad |
| 3 | Fitur login siswa dan admin + pembatasan akses by role | 1 hari | Abbad |
| 4 | Halaman profil data diri siswa | 1 hari | Abbad |
| 5 | Tampilan dan fitur CV Builder | 2 hari | Syafiq |
| 6 | Fitur analisis CV dengan AI | 3 hari | Syafiq |
| 7 | Export CV ke PDF | 1 hari | Alief |
| 8 | Template CV dan manajemen sertifikat | 2 hari | Alief |
| 9 | Multi-CV dan riwayat CV | 3 hari | Alief |
| 10 | Form pengisian data diri alumni | 1 hari | Hanif |
| 11 | Dashboard rekap data alumni untuk admin | 1 hari | Salman |
| 12 | CRUD lowongan kerja (admin) | 2 hari | Salman |
| 13 | Daftar lowongan kerja dan input lamaran (sisi siswa) | 3 hari | Hanif |
| 14 | Pelacakan status lamaran oleh siswa | 2 hari | Hanif |
| 15 | Dashboard admin monitoring job tracker | 2 hari | Salman |
| 16 | Analisis data lamaran dengan AI (admin) | 2 hari | Syafiq |

## 10. Metrik Keberhasilan

*Asumsi awal, perlu disepakati dengan klien:*

- 100% siswa kelas bekerja memiliki minimal satu CV aktif dalam sistem dalam satu bulan setelah rilis.
- Data alumni baru tercatat otomatis dari momen rilis, tanpa data yang hilang seperti sebelumnya.
- Spreadsheet manual untuk lamaran kelas bekerja tidak lagi digunakan setelah rilis.
---

# Konvensi Kode & Konfigurasi Proyek

Bagian ini adalah ringkasan konvensi implementasi. Jika bertentangan dengan PRD
di atas, PRD menang; perbarui bagian ini saat konvensi berubah.

## Stack

- Laravel 13 + Blade (Breeze), Tailwind CSS **3** (bukan v4), Alpine.js, Vite 8.
- Build CSS memakai PostCSS: `tailwind.config.js` + `postcss.config.js`.
  Jangan menambahkan `@tailwindcss/vite` atau sintaks `@theme`/`@source` v4.

## Peran & Otorisasi

- Nilai `users.role` hanya: `siswa`, `alumni`, `admin` (enum `App\Enums\UserRole`).
- Registrasi mandiri hanya boleh `siswa` dan `alumni`; admin dibuat lewat seeder.
- Middleware `role:siswa,alumni` mendukung beberapa peran sekaligus.
- Route per area: publik di `routes/web.php`, admin di `routes/admin.php`
  (prefix `/admin`, nama `admin.*`), API di `routes/api.php` (`auth:sanctum`).
- Siswa/alumni → `/dashboard`; admin → `/admin`. `role:admin` wajib di route admin.

## Keamanan

- Password baru wajib mengikuti `Password::defaults()` (min 12, campuran, simbol,
  `uncompromised`) dari `AppServiceProvider`.
- Semua form web memakai CSRF bawaan; jangan nonaktifkan `SecurityHeaders`.
- Cookie sesi: `HttpOnly`, `SameSite=Lax`, `Secure` otomatis di non-local,
  `SESSION_ENCRYPT=true`.
- Token API: Sanctum, prefix `cvb_`, kedaluwarsa 7 hari, ability = nilai role.
  Cabut semua token saat password diganti (sudah di `PasswordController`).
- Operasi sensitif (profil, ubah password) di belakang `password.confirm`.

## Pola Kode

- Model memakai atribut `#[Fillable]`/`#[Hidden]` (gaya Laravel 13), bukan `$fillable`.
- Validasi di FormRequest (`app/Http/Requests`), bukan di controller bila > 3 field.
- Semua teks antarmuka berbahasa Indonesia.
- Warna tema: `ink`, `forest`, `moss`, `mint`, `fog`, `mist`, `clay` (lihat `tailwind.config.js`).
  Hindari `gray-*`/`indigo-*`.

## Testing

- `php artisan test` (Pest, `RefreshDatabase` aktif untuk `Feature`).
- Untuk route di belakang `password.confirm`, gunakan helper `actingAsConfirmed($this, $user)`.
- Setiap perubahan otorisasi wajib punya test 403/401.

## Perintah rutin

```bash
php artisan migrate --seed   # seeder idempoten (updateOrCreate)
npm run build                # atau npm run dev
php artisan test
./vendor/bin/pint
```
