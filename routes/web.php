<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TestComponent;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\RegistrationRevision;
use App\Http\Livewire\Dashboard\ProjectDetail;
use App\Http\Controllers\ChatController;

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

Route::get('/register/revision/{user}', RegistrationRevision::class)
    ->name('registration.revision')
    ->middleware('signed');

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

Route::view('/dashboard/home', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.home');

Route::view('/dashboard/projects', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.projects');

Route::view('/dashboard/tasks', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.tasks');

Route::view('/dashboard/account', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.account');

Route::view('/dashboard/approve', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.approve');

Route::view('/dashboard/settings', 'dashboard')
    ->middleware(['auth', 'approved'])
    ->name('dashboard.settings');

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

Route::get('/projects/{project}/chats', [ChatController::class, 'fetchMessages'])->name('chats.fetch');
Route::post('/projects/{project}/chats', [ChatController::class, 'sendMessage'])->name('chats.send');
