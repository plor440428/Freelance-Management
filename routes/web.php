<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TestComponent;
use App\Http\Livewire\Auth\Register;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/login-mvc', [\App\Http\Controllers\Auth\LoginController::class, 'show'])
    ->name('login.mvc')
    ->middleware('guest');

Route::post('/login-mvc', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->name('login.mvc.submit')
    ->middleware('guest');

Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
