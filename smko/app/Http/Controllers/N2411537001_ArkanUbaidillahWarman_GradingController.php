<?php
namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class N2411537001_ArkanUbaidillahWarman_GradingController extends Controller
{
    private function routePrefix(): string { return request()->segment(1) ?: 'admin'; }
    private function ensureCanGrade(Submission $submission): void { if (auth()->user()->role === 'guru' && $submission->assignment->course->teacher_id !== auth()->id()) abort(403, 'Guru hanya boleh menilai submission pada kursus miliknya.'); }
    public function index(Request $request): View
    {
        $query = Submission::with(['student','assignment.course.teacher'])->whereNotNull('submitted_at');
        if (auth()->user()->role === 'guru') $query->whereHas('assignment.course', fn($q)=>$q->where('teacher_id', auth()->id()));
        if ($request->filled('course_id')) $query->whereHas('assignment', fn($q)=>$q->where('course_id', $request->course_id));
        $submissions = $query->latest()->paginate(5)->withQueryString();
        $courses = auth()->user()->role === 'guru' ? Course::where('teacher_id',auth()->id())->get() : Course::with('teacher')->get();
        $average = (clone $query)->whereNotNull('score')->avg('score');
        return view('2411537001_ArkanUbaidillahWarman_submissions.grades', compact('submissions','courses','average'));
    }
    public function edit(Submission $submission): View { $submission->load(['student','assignment.course']); $this->ensureCanGrade($submission); return view('2411537001_ArkanUbaidillahWarman_submissions.grade-form', ['submission'=>$submission, 'action'=>route($this->routePrefix().'.grades.update',$submission)]); }
    public function update(GradeRequest $request, Submission $submission): RedirectResponse { $submission->load('assignment.course'); $this->ensureCanGrade($submission); $submission->update(['score'=>$request->validated()['score']]); return redirect()->route($this->routePrefix().'.grades.index')->with('success','Nilai submission berhasil disimpan.'); }
}
