# Keterangan Teknis — Sprint Autentikasi (Abbad)

Dokumen ini merupakan keterangan tertulis (semacam kontrak kerja teknis) untuk
sprint backlog **No. 1–4** yang dikerjakan oleh **Abbad** pada proyek
**Sistem CV Builder — SMK Informatika Pesat**.

| Item | Keterangan |
| :--- | :--- |
| Proyek | Sistem CV Builder (Group ID: Abbad, Alief, Hanif, Salman, Syafiq) |
| Klien | Bapak Raenal Apriansyah, S.Kom — Guru Produktif DKV & Wakasek Hubungan Industri |
| Unit | SMK Informatika Pesat |
| Branch | `authentication` |
| Stack | Laravel 13, Laravel Breeze (Blade), Laravel Sanctum 4.3, Tailwind CSS 3, Alpine.js, Vite 8 |
| PIC Sprint | Abbad |
| Tanggal | 9 November 2026 |
| Status | **Selesai** — 36 test otomatis lulus, build aset berhasil |

---

## 1. Lingkup Pekerjaan (Sprint Backlog Abbad)

| No | User Story / Tugas | Target | Status |
| :--- | :--- | :--- | :--- |
| 1 | Membuat desain halaman register & login | 1 hari | Selesai |
| 2 | Membuat fitur register siswa (dengan status siswa/alumni) | 1 hari | Selesai |
| 3 | Membuat fitur login siswa dan admin + pembatasan akses by role | 1 hari | Selesai |
| 4 | Halaman profil data diri siswa (pendidikan, pengalaman, skill) | 1 hari | Selesai |
| — | Penambahan pengamanan autentikasi (permintaan tambahan) | — | Selesai |

> Disesuaikan dengan PRD pada `AGENTS.md` (peran **siswa, alumni, admin**).

---

## 2. Fitur yang Diserahkan

### 2.1 Halaman Login & Register
- Desain baru bertema hijau (Sora/Manrope), memakai komponen Tailwind yang
  terpusat: `resources/views/auth/login.blade.php`,
  `resources/views/auth/register.blade.php`, `resources/views/layouts/guest.blade.php`.
- Pesan antarmuka dalam Bahasa Indonesia.
- Tampilan responsif (mobile & desktop).

### 2.2 Register Siswa & Alumni
- Pendaftar memilih **status**: Siswa aktif atau Alumni.
- Role `admin` **tidak dapat** dikirim dari form; bila dicoba, request ditolak
  dengan error validasi (tidak ada akun yang dibuat).
- Validasi: nama wajib, email unik + format valid, password dikonfirmasi dan kuat.
- Setelah register langsung login dan diarahkan ke `/dashboard`.

### 2.3 Login Siswa, Alumni, dan Admin
- Satu halaman login untuk ketiga peran.
- Setelah login, pengguna diarahkan otomatis berdasarkan peran:
  - **Admin** → `/admin`
  - **Siswa / Alumni** → `/dashboard`
- Setelah logout, sesi dihapus total dan token CSRF dibuat ulang.

### 2.4 Profil Data Diri (sumber data CV & AI)
- Halaman `/profile/data` untuk siswa dan alumni.
- Data: Nomor HP, alamat, jurusan, tahun lulus, pendidikan, pengalaman, skill,
  link portofolio, dan LinkedIn.
- Skill wajib diisi; tahun lulus divalidasi (alumni: tahun lampau) agar AI punya
  data minimum untuk dianalisis.
- Satu baris `user_profiles` per pengguna (relasi 1:1), tersimpan/terupdate otomatis.
- Admin **tidak** dapat mengakses halaman ini (403).

---

## 3. Arsitektur Peran & Pemisahan Halaman

| Area | URL | Middleware | Akses |
| :--- | :--- | :--- | :--- |
| Publik | `/`, `/login`, `/register` | `guest` (login/register) | Semua |
| Siswa & Alumni | `/dashboard` | `auth`, `role:siswa,alumni` | Siswa, Alumni |
| Admin | `/admin` | `auth`, `role:admin` | Admin saja |
| Profil akun | `/profile` | `auth`, `password.confirm` | Semua pengguna login |
| Data diri | `/profile/data` | `auth`, `role:siswa,alumni`, `password.confirm` | Siswa, Alumni |
| API | `/api/*` | `auth:sanctum` | Pemegang token valid |

- Peran disimpan di kolom `users.role` (enum DB: `siswa`, `alumni`, `admin`)
  dan dipetakan ke enum `App\Enums\UserRole`.
- Middleware `EnsureUserHasRole` menerima beberapa peran sekaligus
  (`role:siswa,alumni`) dan menolak akses dengan **HTTP 403** bila tidak sesuai.
- Route admin berada di file terpisah `routes/admin.php` dengan prefix `/admin`
  dan nama route `admin.*`.
- Pengunjung yang belum login diarahkan ke `/login` (HTTP 302).

**Hasil verifikasi (uji HTTP nyata):**

| Skenario | Hasil |
| :--- | :--- |
| Login admin | Redirect → `/admin` (302) |
| Admin buka `/admin` | 200 OK |
| Admin buka `/dashboard` (area siswa) | 403 |
| Login siswa | Redirect → `/dashboard` (302) |
| Siswa buka `/dashboard` | 200 OK |
| Siswa buka `/admin` | 403 |
| Login alumni | Redirect → `/dashboard` (302) |
| Alumni buka `/dashboard` | 200 OK |
| Alumni buka `/admin` | 403 |

---

## 4. Keamanan (Security)

### 4.1 Ringkasan

| Aspek | Implementasi |
| :--- | :--- |
| Hash password | Bcrypt (bawaan Laravel), tidak disimpan plaintext |
| Kebijakan password | Minimal 8 karakter; tanpa syarat huruf besar, angka, atau simbol |
| Session hijacking | ID sesi dibuat ulang setelah login |
| Session fixation | Sesi di-flush dan di-invalidate saat logout |
| Enkripsi sesi | `SESSION_ENCRYPT=true` |
| Cookie sesi | `HttpOnly` aktif, `SameSite=Lax`, `Secure` otomatis di non-local |
| Masa berlaku sesi | 60 menit |
| Brute-force login | Maksimal 5 percobaan gagal, kunci 15 menit (per email + IP) |
| Token API | Sanctum, 7 hari, prefix `cvb_`, ability sesuai peran |
| Revoke token | Endpoint logout API + otomatis cabut semua token saat password diganti |
| HTTPS | `URL::forceScheme('https')` di produksi + HSTS |
| CSRF | Bawaan Laravel pada semua form web |
| XSS | Escaping Blade (`{{ }}`), CSP ketat |

### 4.2 Header Keamanan
Middleware `App\Http\Middleware\SecurityHeaders` menambahkan header berikut ke
semua respons web:

| Header | Nilai |
| :--- | :--- |
| `X-Content-Type-Options` | `nosniff` |
| `X-Frame-Options` | `DENY` (cegah clickjacking) |
| `Referrer-Policy` | `strict-origin-when-cross-origin` |
| `Permissions-Policy` | `camera=(), microphone=(), geolocation=(), payment=()` |
| `Cross-Origin-Opener-Policy` | `same-origin` |
| `Content-Security-Policy` | `default-src 'self'; frame-ancestors 'none'; object-src 'none'; form-action 'self'` (longgar hanya di mode dev Vite) |
| `Strict-Transport-Security` | `max-age=31536000; includeSubDomains` (hanya HTTPS) |

### 4.3 API Token (Sanctum)

Digunakan untuk integrasi non-browser (analisis AI CV, aplikasi mobile, dsb).
Aplikasi web tetap memakai **cookie sesi + CSRF** karena lebih aman terhadap XSS
daripada token yang disimpan di JavaScript.

| Method | Endpoint | Middleware | Keterangan |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/auth/token` | `throttle:5,1` | Login API → menerbitkan token |
| `GET` | `/api/me` | `auth:sanctum`, `throttle:60,1` | Info pengguna dari token |
| `DELETE` | `/api/auth/token` | `auth:sanctum` | Cabut token saat ini |

**Contoh permintaan tersedia:** body berisi `email`, `password`, `device_name`.
**Contoh respons (201):**

```json
{
  "token": "1|cvb_Q4XZP7EwqisdVx96lRZRxEDZ4ppoqDl8i1zgSlTib8f3a864",
  "abilities": ["siswa"],
  "expires_at": "2026-11-16T07:05:02.000000Z"
}
```

Token dengan ability `admin` diberikan otomatis untuk akun admin, sehingga
endpoint admin berbasis API dapat dibatasi dengan `ability:admin`.

---

## 5. Struktur File yang Ditambahkan/Diubah

| File | Keterangan |
| :--- | :--- |
| `app/Enums/UserRole.php` | Enum peran (Siswa, Admin) |
| `app/Http/Middleware/EnsureUserHasRole.php` | Middleware pembatas peran |
| `app/Http/Middleware/SecurityHeaders.php` | Middleware header keamanan + CSP |
| `app/Http/Controllers/Auth/*` | Controller autentikasi Breeze (disesuaikan) |
| `app/Http/Controllers/Api/AuthTokenController.php` | Terbitkan/cabut token |
| `app/Http/Controllers/Api/MeController.php` | Profil pengguna via token |
| `app/Providers/AppServiceProvider.php` | Kebijakan password + force HTTPS |
| `app/Models/User.php` | `HasApiTokens`, cast role, helper `isAdmin()`/`isSiswa()` |
| `routes/web.php`, `routes/admin.php`, `routes/api.php`, `routes/auth.php` | Definisi route per area |
| `database/factories/UserFactory.php` | State `admin()` untuk testing |
| `database/seeders/DatabaseSeeder.php` | Akun admin & siswa demo |
| `config/sanctum.php`, `config/session.php` | Konfigurasi token & cookie |
| `resources/views/auth/*`, `layouts/*`, `dashboard.blade.php`, `admin/dashboard.blade.php` | Halaman UI |
| `tailwind.config.js`, `postcss.config.js`, `vite.config.js` | Perbaikan pipeline build Tailwind 3 |

---

## 6. Akun Demo (hasil seeder)

| Peran | Email | Password |
| :--- | :--- | :--- |
| Admin | `admin@pesat.sch.id` | `password` |
| Siswa | `siswa@pesat.sch.id` | `password` |
| Alumni | `alumni@pesat.sch.id` | `password` |

> Password demo hanya untuk lingkungan lokal. Pada pengujian fitur ubah password,
> kebijakan password baru (min. 8 karakter) tetap berlaku.

---

## 7. Pengujian

Perintah: `php artisan test`

| Berkas Test | Cakupan | Jumlah |
| :--- | :--- | :--- |
| `tests/Feature/Auth/AuthenticationTest.php` | Login siswa/admin/alumni, redirect per peran, rate limit, regenerasi ID sesi, logout, proteksi halaman | 10 |
| `tests/Feature/Auth/RegistrationTest.php` | Register siswa/alumni, tolak password lemah, tolak escalation ke admin | 6 |
| `tests/Feature/SecurityTest.php` | Token (terbit, ability, revoke, expiry, rate limit), header keamanan, revoke token saat ganti password | 10 |
| `tests/Feature/UserProfileTest.php` | Profil data diri: akses per peran, simpan/update, validasi, isolasi antar pengguna | 9 |
| `tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php` | Smoke test | 2 |

**Hasil akhir: 36 test lulus (95 assertions).**

---

## 8. Cara Menjalankan

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build          # atau: npm run dev
php artisan serve
```

---

## 9. Batasan & Catatan Lanjutan

- Dashboard admin dan siswa/alumni saat ini berupa **placeholder**; data monitoring,
  rekap alumni, lowongan, job tracker, dan CV Builder dikerjakan oleh PIC masing-masing
  (Alief/Hanif/Salman/Syafiq) dan **tidak** termasuk pekerjaan ini.
- Verifikasi email belum diaktifkan. Untuk peningkatan keamanan berikutnya,
  disarankan mengaktifkan `MustVerifyEmail` sebelum fitur CV diluncurkan.
- `APP_DEBUG` wajib `false` di produksi.
- Untuk pengujian di luar lingkungan lokal, gunakan HTTPS agar cookie `Secure`
  dan HSTS aktif.

---

## 10. Persetujuan

| Peran | Nama | Tanggal | Tanda Tangan |
| :--- | :--- | :--- | :--- |
| PIC Developer | Abbad | 9 Nov 2026 | |
| Project Lead | | | |
| Klien (Wakasek Hubungan Industri) | Bapak Raenal Apriansyah, S.Kom | | |
