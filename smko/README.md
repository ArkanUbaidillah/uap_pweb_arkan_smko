# Sistem Manajemen Kelas Online (SMKO)

Project Ujian Akhir Praktikum Pemrograman Web.

- **Nama/NIM Prefix:** `2411537001_ArkanUbaidillahWarman`
- **Topik:** Sistem Manajemen Kelas Online (SMKO)
- **Stack:** Laravel 12, Blade, MySQL, SB Admin Bootstrap 5
- **Middleware role:** Custom middleware `CheckRole` dengan alias `check.role`

## Role dan Hak Akses

### Admin
- CRUD semua data
- Kelola akun guru dan siswa
- CRUD semua kursus dan tugas
- Melihat submission
- Input/edit nilai submission
- Melihat rekap nilai semua siswa

### Guru
- CRUD kursus miliknya sendiri
- CRUD tugas pada kursus miliknya sendiri
- Melihat submission pada kursus miliknya
- Input/edit nilai submission pada kursus miliknya
- Melihat rekap nilai kursus miliknya

### Siswa
- Melihat daftar kursus
- Enroll dan batalkan enroll kursus
- Kumpul tugas
- Melihat submission dan nilai miliknya sendiri

## Struktur Tabel Utama

1. `users`
2. `courses`
3. `enrollments`
4. `assignments`
5. `submissions`

## Akun Demo

Semua password akun demo adalah:

```text
password
```

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

## Langkah Instalasi Lokal

1. Ekstrak ZIP project.
2. Masuk ke folder project:

```bash
cd smko
```

3. Install dependency PHP:

```bash
composer install
```

4. Copy file environment:

```bash
copy .env.example .env
```

Untuk Linux/Mac:

```bash
cp .env.example .env
```

5. Generate app key:

```bash
php artisan key:generate
```

6. Buat database MySQL:

```sql
CREATE DATABASE smko_db;
```

7. Sesuaikan konfigurasi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smko_db
DB_USERNAME=root
DB_PASSWORD=
```

8. Jalankan migration dan seeder:

```bash
php artisan migrate --seed
```

9. Buat symbolic link storage untuk upload file:

```bash
php artisan storage:link
```

10. Install dependency frontend jika diperlukan:

```bash
npm install
npm run dev
```

11. Jalankan server Laravel:

```bash
php artisan serve
```

12. Buka aplikasi:

```text
http://127.0.0.1:8000
```

## Fitur Bonus yang Sudah Ada

- Pagination pada daftar kursus, tugas, submission, user, dan rekap nilai.
- Search kursus berdasarkan nama/kode.
- Filter tugas dan rekap nilai berdasarkan kursus.
- Flash message sukses/gagal.
- Otorisasi granular di controller untuk membatasi guru hanya mengelola data miliknya sendiri.

## Catatan Penamaan Prefix

Folder view menggunakan prefix sesuai instruksi:

```text
2411537001_ArkanUbaidillahWarman_courses
2411537001_ArkanUbaidillahWarman_assignments
2411537001_ArkanUbaidillahWarman_submissions
2411537001_ArkanUbaidillahWarman_users
2411537001_ArkanUbaidillahWarman_dashboard
```

Untuk controller PHP, class tidak boleh diawali angka. Karena itu controller memakai prefix aman:

```text
N2411537001_ArkanUbaidillahWarman_CourseController
N2411537001_ArkanUbaidillahWarman_EnrollmentController
N2411537001_ArkanUbaidillahWarman_AssignmentController
N2411537001_ArkanUbaidillahWarman_SubmissionController
N2411537001_ArkanUbaidillahWarman_GradingController
N2411537001_ArkanUbaidillahWarman_UserController
```

## Urutan Demo Video Disarankan

1. Perkenalan project SMKO dan role.
2. Tunjukkan migration dan seeder.
3. Tunjukkan model dan relationship.
4. Tunjukkan middleware `CheckRole`.
5. Tunjukkan route group admin/guru/siswa.
6. Demo login admin, guru, siswa.
7. Demo hak akses berbeda tiap role.
8. Tunjukkan fitur bonus: pagination, search/filter, flash message.
