@extends('layouts.app')
@section('title','Kelola Akun Guru & Siswa')
@section('content')
<div class="mb-3 text-end"><a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tambah User</a></div><div class="card"><table class="table table-hover mb-0"><tr><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr>@foreach($users as $user)<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td><span class="badge bg-primary">{{ $user->role }}</span></td><td class="d-flex gap-1"><a class="btn btn-sm btn-info" href="{{ route('admin.users.show',$user) }}">Detail</a><a class="btn btn-sm btn-warning" href="{{ route('admin.users.edit',$user) }}">Edit</a><form method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Hapus user?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Hapus</button></form></td></tr>@endforeach</table></div><div class="mt-3">{{ $users->links() }}</div>
@endsection
