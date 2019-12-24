@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/home.css') }}" rel="stylesheet">
@stop
@section('content')

    <h1 class="mt-4">Hi {{ auth()->user()->name }}</h1>
    <p>Welcome to your homepage. In this page you can view your friends posts and keep up to date. You may navigate to other pages using the side menu to the left. For more instructions please click <a href="#"><b>here</b></a>.</p>

@endsection
