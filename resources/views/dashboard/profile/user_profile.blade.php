@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile.css') }}" rel="stylesheet">
@stop
@section('content')
  <div class="row">
    <div class="col-md-12">

    <div class="row">
      <div id="profile-img-wrapper" class="col-md-6">
        <img src="img/user.jpg" id="profile-img" class="mx-auto d-block img-thumbnail">
      </div>
      <div class="col-md-6">

        <h4><u>About</u></h4>
        @if(is_null($user->about) == 0 or count($user->about) == 0)
          <p>User has not written their about section yet.</p>
        @else
          <p>{{ $user->about }}</p>
        @endif

      </div>
    </div>
    <!-- <div class="row">
      <div id="profile-img-upload-wrapper" class="col-md-6">
        <button type="button" id="profile-img-upload-btn" class="btn btn-sm btn-light" name="button">Upload Photo</button>
      </div>
      <div class="col-md-6"></div>
    </div> -->
    <div class="row">
      <div class="col-md-6">
        <h1 id="profile-name" class="mt-4">{{ $user->name }}</h1>
      </div>
      <div class="col-md-6">
        <h5>Date of birth</h5>
      </div>
    </div>

  </div>

</div>


@endsection
