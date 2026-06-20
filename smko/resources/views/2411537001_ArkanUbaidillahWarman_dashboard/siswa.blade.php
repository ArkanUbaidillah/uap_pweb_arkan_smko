@extends('layouts.app')
@section('title','Dashboard Siswa')
@section('content')
<div class='row g-3'><x-stat title='Kursus Diikuti' value='{{ $enrollments }}' color='success'/><x-stat title='Submission Saya' value='{{ $submissions }}' color='info'/><x-stat title='Sudah Dinilai' value='{{ $scores }}' color='warning'/></div><div class='card mt-4'><div class='card-body'>Siswa dapat enroll kursus, kumpul tugas, dan melihat nilai sendiri.</div></div>
@endsection
