<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_AssignmentController as AssignmentController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_CourseController as CourseController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_EnrollmentController as EnrollmentController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_GradingController as GradingController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_SubmissionController as SubmissionController;
use App\Http\Controllers\N2411537001_ArkanUbaidillahWarman_UserController as UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => auth()->check() ? redirect('/dashboard') : redirect('/login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'check.role:admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('submissions', SubmissionController::class)->only(['index', 'show', 'destroy']);
    Route::get('grades', [GradingController::class, 'index'])->name('grades.index');
    Route::get('grades/{submission}/edit', [GradingController::class, 'edit'])->name('grades.edit');
    Route::put('grades/{submission}', [GradingController::class, 'update'])->name('grades.update');
});

Route::group(['prefix' => 'guru', 'as' => 'guru.', 'middleware' => ['auth', 'check.role:guru']], function () {
    Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
    Route::resource('courses', CourseController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('submissions', SubmissionController::class)->only(['index', 'show']);
    Route::get('grades', [GradingController::class, 'index'])->name('grades.index');
    Route::get('grades/{submission}/edit', [GradingController::class, 'edit'])->name('grades.edit');
    Route::put('grades/{submission}', [GradingController::class, 'update'])->name('grades.update');
});

Route::group(['prefix' => 'siswa', 'as' => 'siswa.', 'middleware' => ['auth', 'check.role:siswa']], function () {
    Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
    Route::resource('courses', CourseController::class)->only(['index', 'show']);
    Route::resource('enrollments', EnrollmentController::class)->only(['store', 'destroy']);
    Route::resource('submissions', SubmissionController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
});
