@extends('layouts.app')
@section('title','Input/Edit Nilai')
@section('content')
<div class="card"><div class="card-body"><p>Siswa: <strong>{{ $submission->student->name }}</strong></p><p>Tugas: <strong>{{ $submission->assignment->title }}</strong> - {{ $submission->assignment->course->name }}</p><p>File/Link: {{ $submission->file_path }}</p><form method="POST" action="{{ $action }}">@csrf @method('PUT')<div class="mb-3"><label>Nilai 0-100</label><input type="number" name="score" min="0" max="100" value="{{ old('score',$submission->score) }}" class="form-control" required></div><button class="btn btn-primary">Simpan Nilai</button><a href="{{ route(auth()->user()->role.'.grades.index') }}" class="btn btn-secondary">Kembali</a></form></div></div>
@endsection
