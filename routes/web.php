<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TestComponent;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Dashboard\ProjectDetail;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/test', TestComponent::class);

Route::view('/login', 'auth.login')
    ->name('login')
    ->middleware('guest');

Route::get('/register', Register::class)
    ->name('register')
    ->middleware('guest');

Route::view('/forgot-password', 'auth.forgot-password')
    ->name('password.request')
    ->middleware('guest');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})
    ->name('password.reset')
    ->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'approved'])->name('dashboard');

Route::view('/dashboard/projects', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.projects');

Route::get('/dashboard/projects/{id}', ProjectDetail::class)
    ->middleware(['auth', 'approved'])
    ->name('dashboard.projects.detail');

Route::get('/login-mvc', [\App\Http\Controllers\Auth\LoginController::class, 'show'])
    ->name('login.mvc')
    ->middleware('guest');

Route::post('/login-mvc', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('login.mvc.submit')
    ->middleware('guest');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Admin routes
Route::middleware(['auth', 'approved'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])
        ->name('users.create');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])
        ->name('users.store');
});
