@extends('layouts.app')
@section('title','Rekap Nilai')
@section('content')
@php($role=auth()->user()->role)
<div class="d-flex justify-content-between mb-3"><form class="d-flex gap-2"><select name="course_id" class="form-select"><option value="">Semua kursus</option>@foreach($courses as $course)<option value="{{ $course->id }}" @selected(request('course_id')==$course->id)>{{ $course->name }}</option>@endforeach</select><button class="btn btn-outline-primary">Filter</button></form><div class="alert alert-info mb-0 py-2">Rata-rata: <strong>{{ number_format($average ?? 0, 2) }}</strong></div></div>
<div class="card"><table class="table mb-0"><tr><th>Siswa</th><th>Kursus</th><th>Tugas</th><th>Nilai</th><th>Aksi</th></tr>@forelse($submissions as $s)<tr><td>{{ $s->student->name }}</td><td>{{ $s->assignment->course->name }}</td><td>{{ $s->assignment->title }}</td><td>{{ $s->score ?? 'Belum dinilai' }}</td><td><a class="btn btn-sm btn-warning" href="{{ route($role.'.grades.edit',$s) }}">Input/Edit Nilai</a></td></tr>@empty<tr><td colspan="5" class="text-center">Belum ada data submission.</td></tr>@endforelse</table></div><div class="mt-3">{{ $submissions->links() }}</div>
@endsection
