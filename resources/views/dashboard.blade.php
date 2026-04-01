@extends('layouts.app')

@section('content')
  @livewire('dashboard.container', [], key(request()->path()))
@endsection
