<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

## Foundational Context

This application is a Laravel application running on PHP 8.5. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If a frontend change doesn't show in the UI or you get a "Unable to locate file in Vite manifest" error, run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Use `search-docs` before changes that depend on Laravel ecosystem APIs, behavior, configuration, or version-specific syntax. Skip it for copy-only edits and other changes where package documentation is irrelevant. Reuse sufficient results already in context instead of searching again.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists, including path-scoped framework guidelines under `.ai/rules/boost`. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.
- Activate the `deploying-to-cloud` skill whenever deploying to Laravel Cloud, configuring Cloud environments or resources, using the Cloud CLI, or troubleshooting Cloud deployments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

# Pest

- This project uses Pest. Create tests with `php artisan make:test --pest {name}`.
- Do not include the test suite directory in `{name}`. Use `SomeFeatureTest`, not `Feature/SomeFeatureTest`.
- Read the `testing-best-practices` skill for guidance on coverage, naming, structure, dependency isolation, and review.
- Do not delete tests or test files without approval. They are part of the application.

## Running Tests

- Run the narrowest set of tests that covers the change. Pass a file path or `--filter=testName` to `php artisan test --compact`.
- Rerun a test after each change to it.
- Run `vendor/bin/pest` to call the test runner directly. It accepts the same file path and `--filter=testName` arguments.

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

- Password baru wajib mengikuti `Password::defaults()` (min 8 karakter, tanpa
  syarat kapital/angka/simbol) dari `AppServiceProvider`.
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
