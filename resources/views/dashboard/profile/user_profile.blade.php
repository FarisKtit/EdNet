@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile.css') }}" rel="stylesheet">
@stop
@section('content')
  <div class="row">
    <div class="col-md-12">

    <div class="row">

      <div class="col-md-4">


      </div>
      <div id="profile-img-wrapper" class="col-md-4">
        @if(count($user->profile_image_filename) == 0)
          <img src="img/user.jpg" id="profile-img" class="mx-auto d-block img-thumbnail">
        @else
          <img src="storage/{{ $user->profile_image_filename }}" id="profile-img" class="mx-auto d-block img-thumbnail">
        @endif
        <h1 id="profile-name" class="mt-4">{{ $user->name }}</h1>
        <h4 id="profile-occupation">{{ $user->occupations[0]->name }}</h4>
        <p><b>DOB:</b> {{ $user->birthdate }}</p>


      </div>
      <div class="col-md-4">

      </div>

    </div>

  </div>

</div>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <hr>
    <div class="row">
      <div class="col-md-3 profile-btns-section">
        <a href="{{ route('edit_profile') }}"><button type="button" id="profile-edit-btn" class="btn btn-md btn-light" name="button">Edit Profile</button></a>
      </div>
      <div class="col-md-3 profile-btns-section">
        <button type="button" id="profile-view-photos-btn" class="btn btn-md btn-light" name="button">View Photos</button>
      </div>
      <div class="col-md-3 profile-btns-section">
        <button type="button" id="profile-view-friends-btn" class="btn btn-md btn-light" name="button">View Friends</button>
      </div>
      <div class="col-md-3 profile-btns-section">
        <button type="button" id="profile-view-resources-btn" class="btn btn-md btn-light" name="button">View Resources</button>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 profile-about-section">
        @if(count($user->about) != 0)
          <p>{{ $user->about }}</p>
        @endif
      </div>
    </div>
    <hr>
  </div>
  <div class="col-md-3"></div>

</div>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
      </div>
    @endif

    @if(session()->has('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('error') }}
      </div>
    @endif

  </div>
  <div class="col-md-3"></div>

</div>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <form method="post" action="{{ route('create_post') }}">
      {{ csrf_field() }}
      <div class="form-group">
        <textarea class="form-control" id="post" placeholder="Create a post" name="post" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-default user-post-btn">Create Post</button>
    </form>
    <hr>
  </div>
  <div class="col-md-3"></div>

</div>

<div class="row">
  <div class="col-md-3">

  </div>
  <div class="col-md-6">
    @if(count($posts) == 0)
      <div class="row">
        <div class="col-md-12">
          <h5>You have created no posts!</h5>
        </div>

      </div>
    @else
      @foreach($posts as $post)
        <div class="row user-posts">
          <div class="col-md-12 user-post">
            <div class="row">
              <div class="col-md-6">
                <h3>{{ $user->name }}</h3>
                <h5>{{ $user->occupations[0]->name }}</h5>
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

  </div>
</div>


@endsection
