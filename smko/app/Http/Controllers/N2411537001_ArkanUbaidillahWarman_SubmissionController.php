<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class N2411537001_ArkanUbaidillahWarman_SubmissionController extends Controller
{
    public function index(): View
    {
        $query = Submission::with(['assignment.course.teacher', 'student']);
        if (auth()->user()->role === 'siswa') {
            $query->where('student_id', auth()->id());
        }
        if (auth()->user()->role === 'guru') {
            $query->whereHas('assignment.course', fn($q) => $q->where('teacher_id', auth()->id()));
        }
        $submissions = $query->latest()->paginate(5)->withQueryString();
        return view('2411537001_ArkanUbaidillahWarman_submissions.index', compact('submissions'));
    }

    public function create(Request $request): View
    {
        $assignment = Assignment::with('course')->findOrFail($request->assignment_id);
        if (!Enrollment::where('student_id', auth()->id())->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'Anda harus enroll kursus terlebih dahulu.');
        }
        $submission = Submission::where('student_id', auth()->id())->where('assignment_id', $assignment->id)->first() ?? new Submission(['assignment_id' => $assignment->id]);
        return view('2411537001_ArkanUbaidillahWarman_submissions.form', compact('assignment', 'submission'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi inline secara langsung untuk menghindari konflik tipe data di FormRequest terpisah
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'file_path'     => 'required|file|mimes:pdf,doc,docx,zip|max:5120', // Maks 5MB berkas dokumen/arsip
        ], [
            'file_path.required' => 'File tugas wajib diunggah!',
            'file_path.file'     => 'Input harus berupa berkas/file valid.',
            'file_path.mimes'    => 'Format file wajib berupa PDF, DOC, DOCX, atau ZIP.',
            'file_path.max'      => 'Ukuran file maksimal adalah 5MB.',
        ]);

        $assignment = Assignment::findOrFail($request->assignment_id);
        
        // Proteksi Otorisasi Hak Akses Siswa
        if (!Enrollment::where('student_id', auth()->id())->where('course_id', $assignment->course_id)->exists()) {
            abort(403, 'Anda harus enroll kursus terlebih dahulu.');
        }

        // Proses penyimpanan berkas file_path biner secara aman ke dalam folder storage public
        $path = null;
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('submissions', $fileName, 'public');
        }

        // Simpan atau Update record data ke database
        Submission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'student_id'    => auth()->id()
            ], 
            [
                'file_path'     => $path ?? 'Link/berkas dikumpulkan manual',
                'submitted_at'  => now()
            ]
        );

        // Redirect dinamis menggunakan url() agar aman dari error penamaan rute manual
        return redirect('/siswa/dashboard')->with('success', 'Tugas berhasil dikumpulkan.');
    }

    public function show(Submission $submission): View
    {
        $submission->load(['assignment.course', 'student']);
        if (auth()->user()->role === 'siswa' && $submission->student_id !== auth()->id()) abort(403);
        if (auth()->user()->role === 'guru' && $submission->assignment->course->teacher_id !== auth()->id()) abort(403);
        return view('2411537001_ArkanUbaidillahWarman_submissions.show', compact('submission'));
    }

    public function destroy(Submission $submission): RedirectResponse
    {
        if ($submission->student_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }
        $submission->delete(); 
        return back()->with('success', 'Submission berhasil dihapus.');
    }
}
