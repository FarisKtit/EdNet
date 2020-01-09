@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/home.css') }}" rel="stylesheet">
@stop
@section('content')
<div class="row">
  <div class="col-md-3">
      <div class="home-instructions">
        <h1 class="mt-4">Hi {{ auth()->user()->name }}</h1>
        <p>Welcome to your homepage. In this page you can view your friends posts and keep up to date. You may navigate to other pages using the side menu to the left. For more instructions please click <a href="#"><b>here</b></a>.</p>
      </div>
    </div>
  <div class="col-md-6 home-wall">
    <h1>Wall</h1>
    <hr>
    @include('snippets.dashboard.home.home_wall_posts')


  </div>
  <div class="col-md-3">
    <div class="home-updates">
      <br>
      <div class="row">
        <div class="col-md-12">
          <h4>Friend Requests</h4>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <h4>Resource Requests</h4>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <h4>New Messages</h4>
        </div>
      </div>
    </div>

  </div>
</div>
<div class="row">

</div>

@endsection
