<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class N2411537001_ArkanUbaidillahWarman_EnrollmentController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['course_id'=>['required','exists:courses,id']]);
        Enrollment::firstOrCreate(['student_id'=>auth()->id(), 'course_id'=>$data['course_id']], ['enrolled_at'=>now()]);
        return back()->with('success','Berhasil enroll kursus.');
    }
    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        if ($enrollment->student_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);
        $enrollment->delete(); return back()->with('success','Enroll kursus berhasil dibatalkan.');
    }
}
