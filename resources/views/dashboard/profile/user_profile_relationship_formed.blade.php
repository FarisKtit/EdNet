@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile_relationship_formed.css') }}" rel="stylesheet">
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
          <img src="/storage/{{ $user->profile_image_filename }}" id="profile-img" class="mx-auto d-block img-thumbnail">

        @endif
        <h1 id="profile-name" class="mt-4">{{ $user->name }}</h1>
        <h4 id="profile-occupation">{{ $user->occupation }}</h4>
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
      <div class="col-md-4 profile-btns-section">
        <button type="button" id="profile-view-photos-btn" class="btn btn-md btn-light" name="button">View Photos</button>
      </div>
      <div class="col-md-4 profile-btns-section">
        <button type="button" id="profile-view-friends-btn" class="btn btn-md btn-light" name="button">View Friends</button>
      </div>
      <div class="col-md-4 profile-btns-section">
        <button type="button" id="profile-view-resources-btn" class="btn btn-md btn-light" name="button">View Resources</button>
      </div>
    </div>

    @if(count($user->about) != 0)
    <div class="row">
      <div class="col-md-12 profile-about-section">

          <p>{{ $user->about }}</p>

      </div>
    </div>
    @endif
    <hr>
  </div>
  <div class="col-md-3"></div>

</div>

<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-success alert-dismissible" id="post-creation-success-alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Post successfully created!
            </div>

          </div>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-danger alert-dismissible" id="post-creation-error-alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              Error, post could not be created, please try again later.
            </div>

          </div>

        </div>

      </div>

    </div>
    <div class="row">
      <div class="col-md-12">
        <form method="post" action="{{ route('create_post') }}">
          {{ csrf_field() }}
          <input type="hidden" name="visited_id" id="visited_id" value="{{ $visited_id }}">
          <input type="hidden" name="visitor_id" id="visitor_id" value="{{ $visitor_id }}">

          <div class="form-group">
            <textarea class="form-control" id="post" placeholder="Create a post" name="post" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-default user-post-btn" id="user-post-btn">Create Post</button>
        </form>
        <hr>
      </div>
    </div>

  </div>
  <div class="col-md-3"></div>

</div>


<div class="row">
  <div class="col-md-3">

  </div>
  <div class="col-md-6" id="user-profile-posts">
    @include('snippets.dashboard.profile.user_profile_posts')
  </div>
  <div class="col-md-3">

  </div>
</div>

<br><br>


@endsection
@section('scripts')
  <script src="{{ asset('js/dashboard/profile/user_profile.js') }}"></script>
@stop
