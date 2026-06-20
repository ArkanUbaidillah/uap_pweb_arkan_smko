<?php
namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class N2411537001_ArkanUbaidillahWarman_CourseController extends Controller
{
    private function routePrefix(): string { return request()->segment(1) ?: 'admin'; }
    private function ensureCourseOwner(Course $course): void { if (auth()->user()->role === 'guru' && $course->teacher_id !== auth()->id()) abort(403, 'Guru hanya boleh mengelola kursus miliknya sendiri.'); }

    public function index(Request $request): View
    {
        $query = Course::with(['teacher','enrollments'])->withCount(['enrollments','assignments']);
        if (auth()->user()->role === 'guru') $query->where('teacher_id', auth()->id());
        if ($request->filled('search')) $query->where(fn($q)=>$q->where('name','like','%'.$request->search.'%')->orWhere('code','like','%'.$request->search.'%'));
        $courses = $query->latest()->paginate(5)->withQueryString();
        $myEnrollments = auth()->user()->role === 'siswa' ? Enrollment::where('student_id', auth()->id())->pluck('course_id')->toArray() : [];
        return view('2411537001_ArkanUbaidillahWarman_courses.index', compact('courses','myEnrollments'));
    }
    public function create(): View { return view('2411537001_ArkanUbaidillahWarman_courses.form', ['course'=>new Course(), 'teachers'=>User::where('role','guru')->get(), 'action'=>route($this->routePrefix().'.courses.store'), 'method'=>'POST']); }
    public function store(CourseRequest $request): RedirectResponse
    {
        $data = $request->validated(); $data['teacher_id'] = auth()->user()->role === 'admin' ? ($data['teacher_id'] ?? auth()->id()) : auth()->id();
        Course::create($data); return redirect()->route($this->routePrefix().'.courses.index')->with('success','Kursus berhasil dibuat.');
    }
    public function show(Course $course): View { if (auth()->user()->role === 'guru') $this->ensureCourseOwner($course); $course->load(['teacher','assignments.submissions','enrollments.student']); return view('2411537001_ArkanUbaidillahWarman_courses.show', compact('course')); }
    public function edit(Course $course): View { $this->ensureCourseOwner($course); return view('2411537001_ArkanUbaidillahWarman_courses.form', ['course'=>$course, 'teachers'=>User::where('role','guru')->get(), 'action'=>route($this->routePrefix().'.courses.update',$course), 'method'=>'PUT']); }
    public function update(CourseRequest $request, Course $course): RedirectResponse { $this->ensureCourseOwner($course); $data=$request->validated(); if (auth()->user()->role === 'guru') $data['teacher_id']=auth()->id(); $course->update($data); return redirect()->route($this->routePrefix().'.courses.index')->with('success','Kursus berhasil diperbarui.'); }
    public function destroy(Course $course): RedirectResponse { $this->ensureCourseOwner($course); $course->delete(); return back()->with('success','Kursus berhasil dihapus.'); }
}
