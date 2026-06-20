<?php
namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class N2411537001_ArkanUbaidillahWarman_AssignmentController extends Controller
{
    private function routePrefix(): string { return request()->segment(1) ?: 'admin'; }
    private function coursesForUser() { return auth()->user()->role === 'admin' ? Course::orderBy('name')->get() : Course::where('teacher_id', auth()->id())->orderBy('name')->get(); }
    private function ensureOwner(Assignment $assignment): void { if (auth()->user()->role === 'guru' && $assignment->course->teacher_id !== auth()->id()) abort(403, 'Guru hanya boleh mengelola tugas pada kursus miliknya.'); }

    public function index(Request $request): View
    {
        $query = Assignment::with(['course.teacher'])->withCount('submissions');
        if (auth()->user()->role === 'guru') $query->whereHas('course', fn($q)=>$q->where('teacher_id', auth()->id()));
        if ($request->filled('course_id')) $query->where('course_id', $request->course_id);
        $assignments = $query->latest()->paginate(5)->withQueryString();
        return view('2411537001_ArkanUbaidillahWarman_assignments.index', ['assignments'=>$assignments, 'courses'=>$this->coursesForUser()]);
    }
    public function create(): View { return view('2411537001_ArkanUbaidillahWarman_assignments.form', ['assignment'=>new Assignment(), 'courses'=>$this->coursesForUser(), 'action'=>route($this->routePrefix().'.assignments.store'), 'method'=>'POST']); }
    public function store(AssignmentRequest $request): RedirectResponse { $data=$request->validated(); if (auth()->user()->role==='guru' && !Course::where('id',$data['course_id'])->where('teacher_id',auth()->id())->exists()) abort(403); Assignment::create($data); return redirect()->route($this->routePrefix().'.assignments.index')->with('success','Tugas berhasil dibuat.'); }
    public function show(Assignment $assignment): View { $assignment->load(['course.teacher','submissions.student']); $this->ensureOwner($assignment); return view('2411537001_ArkanUbaidillahWarman_assignments.show', compact('assignment')); }
    public function edit(Assignment $assignment): View { $assignment->load('course'); $this->ensureOwner($assignment); return view('2411537001_ArkanUbaidillahWarman_assignments.form', ['assignment'=>$assignment, 'courses'=>$this->coursesForUser(), 'action'=>route($this->routePrefix().'.assignments.update',$assignment), 'method'=>'PUT']); }
    public function update(AssignmentRequest $request, Assignment $assignment): RedirectResponse { $assignment->load('course'); $this->ensureOwner($assignment); $data=$request->validated(); if (auth()->user()->role==='guru' && !Course::where('id',$data['course_id'])->where('teacher_id',auth()->id())->exists()) abort(403); $assignment->update($data); return redirect()->route($this->routePrefix().'.assignments.index')->with('success','Tugas berhasil diperbarui.'); }
    public function destroy(Assignment $assignment): RedirectResponse { $assignment->load('course'); $this->ensureOwner($assignment); $assignment->delete(); return back()->with('success','Tugas berhasil dihapus.'); }
}
