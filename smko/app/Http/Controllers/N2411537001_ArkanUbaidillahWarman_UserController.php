<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class N2411537001_ArkanUbaidillahWarman_UserController extends Controller
{
    public function index(): View { return view('2411537001_ArkanUbaidillahWarman_users.index', ['users'=>User::whereIn('role',['guru','siswa'])->latest()->paginate(5)]); }
    public function create(): View { return view('2411537001_ArkanUbaidillahWarman_users.form', ['user'=>new User(), 'action'=>route('admin.users.store'), 'method'=>'POST']); }
    public function store(UserRequest $request): RedirectResponse { $data=$request->validated(); $data['password']=Hash::make($data['password']); User::create($data); return redirect()->route('admin.users.index')->with('success','User berhasil dibuat.'); }
    public function show(User $user): View { $user->load(['courses','enrollments.course','submissions.assignment']); return view('2411537001_ArkanUbaidillahWarman_users.show', compact('user')); }
    public function edit(User $user): View { return view('2411537001_ArkanUbaidillahWarman_users.form', ['user'=>$user, 'action'=>route('admin.users.update',$user), 'method'=>'PUT']); }
    public function update(UserRequest $request, User $user): RedirectResponse { $data=$request->validated(); if (!empty($data['password'])) $data['password']=Hash::make($data['password']); else unset($data['password']); $user->update($data); return redirect()->route('admin.users.index')->with('success','User berhasil diperbarui.'); }
    public function destroy(User $user): RedirectResponse { if ($user->id === auth()->id()) return back()->with('error','Admin tidak boleh menghapus akun sendiri.'); $user->delete(); return back()->with('success','User berhasil dihapus.'); }
}
