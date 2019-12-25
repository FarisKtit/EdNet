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
        <img src="img/user.jpg" id="profile-img" class="mx-auto d-block img-thumbnail">
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


@endsection
