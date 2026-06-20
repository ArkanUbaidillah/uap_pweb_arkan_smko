<?php
namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(): RedirectResponse { return match (auth()->user()->role) { 'admin' => redirect('/admin/dashboard'), 'guru' => redirect('/guru/dashboard'), default => redirect('/siswa/dashboard') }; }
    public function admin(): View { return view('2411537001_ArkanUbaidillahWarman_dashboard.admin', ['users'=>User::count(), 'courses'=>Course::count(), 'assignments'=>Assignment::count(), 'submissions'=>Submission::count()]); }
    public function guru(): View { $id=auth()->id(); $courseIds=Course::where('teacher_id',$id)->pluck('id'); return view('2411537001_ArkanUbaidillahWarman_dashboard.guru', ['courses'=>Course::where('teacher_id',$id)->count(), 'assignments'=>Assignment::whereIn('course_id',$courseIds)->count(), 'submissions'=>Submission::whereHas('assignment.course', fn($q)=>$q->where('teacher_id',$id))->count()]); }
    public function siswa(): View { $id=auth()->id(); return view('2411537001_ArkanUbaidillahWarman_dashboard.siswa', ['enrollments'=>Enrollment::where('student_id',$id)->count(), 'submissions'=>Submission::where('student_id',$id)->count(), 'scores'=>Submission::where('student_id',$id)->whereNotNull('score')->count()]); }
}
