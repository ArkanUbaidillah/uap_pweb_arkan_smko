@extends('layouts.app')
@section('title','Detail Submission')
@section('content')
<div class="card"><div class="card-body"><h4>{{ $submission->assignment->title }}</h4><p><strong>Kursus:</strong> {{ $submission->assignment->course->name }}</p><p><strong>Siswa:</strong> {{ $submission->student->name }}</p><p><strong>File/Link:</strong> {{ $submission->file_path }}</p><p><strong>Dikumpulkan:</strong> {{ optional($submission->submitted_at)->format('d/m/Y H:i') }}</p><p><strong>Nilai:</strong> <span class="badge bg-{{ $submission->score === null ? 'secondary' : 'success' }}">{{ $submission->score ?? 'Belum dinilai' }}</span></p></div></div>
@endsection
