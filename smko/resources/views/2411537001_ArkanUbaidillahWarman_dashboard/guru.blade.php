@extends('layouts.app')
@section('title','Dashboard Guru')
@section('content')
<div class='row g-3'><x-stat title='Kursus Saya' value='{{ $courses }}' color='success'/><x-stat title='Tugas Saya' value='{{ $assignments }}' color='warning'/><x-stat title='Submission Masuk' value='{{ $submissions }}' color='info'/></div><div class='card mt-4'><div class='card-body'>Guru hanya dapat mengelola kursus dan tugas miliknya sendiri serta memberi nilai submission.</div></div>
@endsection
