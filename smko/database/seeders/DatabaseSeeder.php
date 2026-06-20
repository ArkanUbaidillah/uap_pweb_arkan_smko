<?php
namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create(['name'=>'Admin SMKO','email'=>'admin@smko.test','password'=>Hash::make('password'),'role'=>'admin']);
        $guru1 = User::create(['name'=>'Guru Budi','email'=>'guru1@smko.test','password'=>Hash::make('password'),'role'=>'guru']);
        $guru2 = User::create(['name'=>'Guru Siti','email'=>'guru2@smko.test','password'=>Hash::make('password'),'role'=>'guru']);
        $siswa = collect([
            ['Siswa Andi','siswa1@smko.test'], ['Siswa Rina','siswa2@smko.test'], ['Siswa Dimas','siswa3@smko.test'], ['Siswa Maya','siswa4@smko.test'], ['Siswa Putra','siswa5@smko.test'],
        ])->map(fn($d)=>User::create(['name'=>$d[0], 'email'=>$d[1], 'password'=>Hash::make('password'), 'role'=>'siswa']));

        $course1 = Course::create(['teacher_id'=>$guru1->id,'name'=>'Pemrograman Web Dasar','code'=>'PWD-101','description'=>'Belajar HTML, CSS, PHP, dan dasar Laravel.']);
        $course2 = Course::create(['teacher_id'=>$guru1->id,'name'=>'Basis Data','code'=>'BD-201','description'=>'Perancangan database dan query SQL.']);
        $course3 = Course::create(['teacher_id'=>$guru2->id,'name'=>'Laravel Lanjutan','code'=>'LAR-301','description'=>'MVC, middleware, relationship, dan autentikasi Laravel.']);

        foreach ($siswa as $i => $student) {
            Enrollment::create(['student_id'=>$student->id,'course_id'=>$course1->id,'enrolled_at'=>now()->subDays(10-$i)]);
            if ($i < 3) Enrollment::create(['student_id'=>$student->id,'course_id'=>$course2->id,'enrolled_at'=>now()->subDays(8-$i)]);
            if ($i >= 2) Enrollment::create(['student_id'=>$student->id,'course_id'=>$course3->id,'enrolled_at'=>now()->subDays(6-$i)]);
        }

        $assignments = collect([
            Assignment::create(['course_id'=>$course1->id,'title'=>'Tugas HTML CSS','description'=>'Buat halaman profil sederhana.','due_date'=>now()->addDays(7)->toDateString()]),
            Assignment::create(['course_id'=>$course1->id,'title'=>'Tugas PHP Form','description'=>'Buat form input dan validasi sederhana.','due_date'=>now()->addDays(9)->toDateString()]),
            Assignment::create(['course_id'=>$course2->id,'title'=>'ERD Sistem Akademik','description'=>'Buat ERD lengkap beserta relasi.','due_date'=>now()->addDays(5)->toDateString()]),
            Assignment::create(['course_id'=>$course2->id,'title'=>'Query Join SQL','description'=>'Latihan query join minimal 5 tabel.','due_date'=>now()->addDays(11)->toDateString()]),
            Assignment::create(['course_id'=>$course3->id,'title'=>'CRUD Laravel','description'=>'Implementasikan CRUD dengan migration dan model.','due_date'=>now()->addDays(14)->toDateString()]),
        ]);

        $dataSubmission = [
            [$assignments[0], $siswa[0], 85], [$assignments[0], $siswa[1], 90], [$assignments[1], $siswa[0], null],
            [$assignments[2], $siswa[1], 78], [$assignments[2], $siswa[2], 88], [$assignments[4], $siswa[3], 92],
        ];
        foreach ($dataSubmission as [$assignment, $student, $score]) {
            Submission::create(['assignment_id'=>$assignment->id,'student_id'=>$student->id,'file_path'=>'submissions/contoh-tugas.pdf','score'=>$score,'submitted_at'=>now()->subDays(rand(1,4))]);
        }
    }
}
