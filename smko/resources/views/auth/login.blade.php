@extends('layouts.app')
@section('title','Login SMKO')
@section('content')
<div class="row justify-content-center mt-5"><div class="col-md-5"><div class="card"><div class="card-body p-4"><h4 class="mb-3">Login SMKO</h4><form method="POST" action="/login">@csrf<div class="mb-3"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus></div><div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div><div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label for="remember" class="form-check-label">Remember me</label></div><button class="btn btn-primary w-100">Login</button></form><hr><a href="/register">Daftar sebagai siswa</a><div class="small text-muted mt-3">Demo: admin@smko.test / guru1@smko.test / siswa1@smko.test<br>Password: password</div></div></div></div></div>
@endsection
