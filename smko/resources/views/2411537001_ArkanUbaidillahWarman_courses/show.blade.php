@extends('layouts.app')
@section('title', 'Detail Kursus')

@section('content')
@php($role = auth()->user()->role)

<div class="container-fluid px-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4 mt-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1">{{ $course->name }} <span class="badge bg-secondary">{{ $course->code }}</span></h4>
                    <p class="mb-1 text-muted">Guru Pengampu: <strong>{{ $course->teacher->name }}</strong></p>
                    <p class="mb-0 text-secondary">{{ $course->description ?? 'Tidak ada deskripsi kursus.' }}</p>
                </div>
                <div>
                    {{-- Aksi khusus Siswa untuk melakukan Un-enroll --}}
                    @if($role === 'siswa')
                        @php($enrollment = $course->enrollments->where('student_id', auth()->id())->first())
                        @if($enrollment)
                            <form method="POST" action="{{ url('/siswa/enrollments/' . $enrollment->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan kelas ini?')">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Batalkan Enroll
                                </button>
                            </form>
                        @endif
                    @endif

                    {{-- Tombol Kembali Berdasarkan Role --}}
                    <a href="{{ url('/' . $role . '/courses') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fas fa-tasks me-1"></i> Daftar Tugas Kuliah</span>
                    
                    {{-- Guru pemilik kursus bisa tambah tugas baru --}}
                    @if($role === 'guru' && $course->teacher_id === auth()->id())
                        <a href="{{ url('/guru/assignments/create?course_id=' . $course->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i> Tambah Tugas
                        </a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul Tugas</th>
                                <th>Batas Pengumpulan</th>
                                <th class="text-center" style="width: 250px;">Aksi / Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($course->assignments as $assignment)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary d-block">{{ $assignment->title }}</span>
                                        <small class="text-muted">{{ Str::limit($assignment->description, 70) }}</small>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold small">
                                            {{ $assignment->due_date instanceof \Carbon\Carbon ? $assignment->due_date->format('d M Y, H:i') : \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{-- LOGIKA AKSES SISWA --}}
                                        @if($role === 'siswa')
                                            @php($isEnrolled = $course->enrollments->where('student_id', auth()->id())->count())
                                            
                                            @if($isEnrolled)
                                                @php($submission = $assignment->submissions->where('student_id', auth()->id())->first())
                                                
                                                @if($submission)
                                                    <span class="badge bg-success p-2 mb-1 d-inline-block"><i class="fas fa-check-circle me-1"></i> Sudah Mengumpul</span>
                                                    @if($submission->score !== null)
                                                        <span class="badge bg-info text-dark p-2 d-inline-block">Nilai: <strong>{{ $submission->score }}</strong></span>
                                                    @else
                                                        <span class="badge bg-warning text-dark p-2 d-inline-block">Belum Dinilai</span>
                                                    @endif
                                                @else
                                                    {{-- Form Upload Tugas Langsung ke URL Store Submissions --}}
                                                    <form action="{{ url('/siswa/submissions') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-1 justify-content-center">
                                                        @csrf
                                                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                                        <input type="file" name="file_path" class="form-control form-control-sm" style="max-width: 150px;" required>
                                                        <button type="submit" class="btn btn-sm btn-primary">Kumpul</button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted small">Silakan enroll kelas terlebih dahulu</span>
                                            @endif

                                        {{-- LOGIKA AKSES GURU DAN ADMIN --}}
                                        @elseif($role === 'guru' || $role === 'admin')
                                            <a href="{{ url('/' . $role . '/assignments/' . $assignment->id) }}" class="btn btn-sm btn-info text-white">
                                                <i class="fas fa-eye me-1"></i> Pantau Pengumpulan
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-folder-open d-block mb-2 fa-2x"></i>
                                        Belum ada tugas yang diterbitkan di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light fw-bold text-secondary">
                    <i class="fas fa-users me-1"></i> Mahasiswa Terdaftar ({{ $course->enrollments->count() }})
                </div>
                <ul class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    @forelse($course->enrollments as $e)
                        <li class="list-group-item d-flex align-items-center py-2">
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px; font-size: 13px; font-weight: bold;">
                                {{ strtoupper(substr($e->student->name, 0, 2)) }}
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-bold text-dark d-block" style="font-size: 14px;">{{ $e->student->name }}</span>
                                <small class="text-muted" style="font-size: 11px;">
                                    Mulai: {{ \Carbon\Carbon::parse($e->enrolled_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center py-4">
                            <i class="fas fa-user-slash d-block mb-2 fa-lg"></i>
                            Belum ada mahasiswa di kelas ini.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection