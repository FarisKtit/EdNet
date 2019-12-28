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
    @if(count($posts) == 0)
      <div class="row">
        <div class="col-md-12">
          <h5>No posts!</h5>
        </div>

      </div>
    @else
      @foreach($posts as $post)
        <div class="row">
          <div class="col-md-12 user-post">
            <div class="row">
              <div class="col-md-6">
                <h3>{{ $user->name }}</h3>
                <h5>{{ $user->occupation->name }}</h5>
              </div>
              <div class="col-md-6">
                <h5><b>Created at:</b> {{ $post->created_at }}</h5>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-12">
                <p class="">{{ $post->content }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-default like-btn" name="button">Like</button>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-danger delete-post-btn" name="button">Delete</button>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-default comment-btn" name="button">Comment</button>
              </div>

            </div>
          </div>
        </div>
        <hr>
      @endforeach
    @endif

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
