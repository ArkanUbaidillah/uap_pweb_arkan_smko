# Checklist Selesai - SMKO

**Prefix:** `2411537001_ArkanUbaidillahWarman`  
**Judul Project:** Sistem Manajemen Kelas Online (SMKO)  
**Stack:** Laravel 12, Blade, MySQL, SB Admin Bootstrap 5

## Ringkasan Implementasi

- [x] Project Laravel SMKO dibuat.
- [x] Autentikasi login/register/logout tersedia.
- [x] Register default sebagai siswa.
- [x] Redirect login sesuai role:
  - admin → `/admin/dashboard`
  - guru → `/guru/dashboard`
  - siswa → `/siswa/dashboard`
- [x] Custom middleware `CheckRole` dibuat dan didaftarkan sebagai `check.role`.
- [x] Route dipisah menjadi group admin, guru, dan siswa.
- [x] Migration untuk 5 tabel utama dibuat:
  - `users`
  - `courses`
  - `enrollments`
  - `assignments`
  - `submissions`
- [x] Seeder data awal dibuat:
  - 1 admin
  - 2 guru
  - 5 siswa
  - 3 kursus
  - 5 tugas
  - 6 submission
- [x] Model dan relationship Eloquent dibuat.
- [x] Controller sesuai modul dibuat dengan prefix aman PHP.
- [x] FormRequest untuk validasi form dibuat.
- [x] View Blade dengan folder prefix dibuat.
- [x] Layout SB Admin Bootstrap 5 dibuat.
- [x] Fitur bonus tersedia: pagination, search/filter, flash message.
- [x] README instalasi dibuat.
- [x] ZIP siap submit dibuat.

## Akun Demo

Password semua akun: `password`

| Role | Email |
|---|---|
| Admin | `admin@smko.test` |
| Guru 1 | `guru1@smko.test` |
| Guru 2 | `guru2@smko.test` |
| Siswa 1 | `siswa1@smko.test` |
| Siswa 2 | `siswa2@smko.test` |
| Siswa 3 | `siswa3@smko.test` |
| Siswa 4 | `siswa4@smko.test` |
| Siswa 5 | `siswa5@smko.test` |
