@extends('layouts.app')
@section('title','Detail Tugas')
@section('content')
<div class="card mb-3"><div class="card-body"><h4>{{ $assignment->title }}</h4><p>Kursus: <strong>{{ $assignment->course->name }}</strong> | Deadline: {{ $assignment->due_date->format('d/m/Y') }}</p><p>{{ $assignment->description }}</p></div></div><div class="card"><div class="card-header">Submission</div><table class="table mb-0"><tr><th>Siswa</th><th>Waktu</th><th>Nilai</th></tr>@foreach($assignment->submissions as $s)<tr><td>{{ $s->student->name }}</td><td>{{ optional($s->submitted_at)->format('d/m/Y H:i') }}</td><td>{{ $s->score ?? 'Belum dinilai' }}</td></tr>@endforeach</table></div>
@endsection
