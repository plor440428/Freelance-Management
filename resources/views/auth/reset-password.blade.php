@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-400">
  <div class="w-full max-w-5xl">
    @livewire('auth.reset-password', ['token' => $token])
  </div>
</div>
@endsection
