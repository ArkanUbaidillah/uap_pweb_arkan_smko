@extends('layouts.app')
@section('title','Detail User')
@section('content')
<div class="card"><div class="card-body"><h4>{{ $user->name }}</h4><p>Email: {{ $user->email }}</p><p>Role: <span class="badge bg-primary">{{ $user->role }}</span></p><hr>@if($user->role==='guru')<h5>Kursus Diampu</h5><ul>@foreach($user->courses as $course)<li>{{ $course->name }} ({{ $course->code }})</li>@endforeach</ul>@elseif($user->role==='siswa')<h5>Kursus Diikuti</h5><ul>@foreach($user->enrollments as $e)<li>{{ $e->course->name }}</li>@endforeach</ul><h5>Submission</h5><ul>@foreach($user->submissions as $s)<li>{{ $s->assignment->title }} - Nilai: {{ $s->score ?? 'Belum dinilai' }}</li>@endforeach</ul>@endif</div></div>
@endsection
