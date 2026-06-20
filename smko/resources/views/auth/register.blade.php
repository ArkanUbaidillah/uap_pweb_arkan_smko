@extends('layouts.app')
@section('title','Register Siswa')
@section('content')
<div class="row justify-content-center mt-5"><div class="col-md-5"><div class="card"><div class="card-body p-4"><h4 class="mb-3">Register Siswa</h4><form method="POST" action="/register">@csrf<div class="mb-3"><label>Nama</label><input name="name" value="{{ old('name') }}" class="form-control" required></div><div class="mb-3"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required></div><div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div><div class="mb-3"><label>Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control" required></div><button class="btn btn-primary w-100">Register</button></form><hr><a href="/login">Sudah punya akun?</a></div></div></div></div>
@endsection
