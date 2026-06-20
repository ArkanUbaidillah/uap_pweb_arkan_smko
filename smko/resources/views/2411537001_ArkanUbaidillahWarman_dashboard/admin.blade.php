@extends('layouts.app')
@section('title','Dashboard Admin')
@section('content')
<div class='row g-3'><x-stat title='Total User' value='{{ $users }}' color='primary'/><x-stat title='Kursus' value='{{ $courses }}' color='success'/><x-stat title='Tugas' value='{{ $assignments }}' color='warning'/><x-stat title='Submission' value='{{ $submissions }}' color='info'/></div><div class='card mt-4'><div class='card-body'>Admin dapat CRUD semua data, mengelola akun guru/siswa, kursus, tugas, submission, dan nilai.</div></div>
@endsection
