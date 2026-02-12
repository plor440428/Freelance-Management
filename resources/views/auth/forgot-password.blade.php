@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-400">
  <div class="w-full max-w-5xl">
    @livewire('auth.forgot-password')
  </div>
</div>
@endsection
