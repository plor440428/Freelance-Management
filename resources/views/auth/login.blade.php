@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-400">
  <div class="w-full max-w-4xl">
    @livewire('auth.login')
  </div>
</div>
@endsection
