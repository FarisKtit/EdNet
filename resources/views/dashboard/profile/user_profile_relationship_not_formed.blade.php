@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile_relationship_not_formed.css') }}" rel="stylesheet">
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
    <hr>
    <div class="row" id="profile-btns">
      <div class="col-md-6 profile-btns-section" id="profile-form-relationship-btns">
        @if($count == 0)

        <form method="post" action="{{ route('form_relationship') }}">
          {{ csrf_field() }}
          <input type="hidden" name="responder_id" id="responder_id" value="{{ $visited_id }}">
          <button type="submit" id="profile-view-form-relationship-btn" class="btn btn-md btn-light" name="button">Form Relationship</button>
        </form>

        @else
        <form method="post" action="{{ route('cancel_relationship_request') }}">
          {{ csrf_field() }}
          <input type="hidden" name="responder_id" id="responder_id" value="{{ $visited_id }}">
          <button type="submit" id="profile-view-cancel-relationship-request" class="btn btn-md btn-light" name="button">Cancel Relationship Request</button>
        </form>
        @endif
      </div>
      <div class="col-md-6 profile-btns-section">
        <button type="button" id="profile-view-resources-btn" class="btn btn-md btn-light" name="button">View Resources</button>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <input type="hidden" id="responder_id" name="responder_id" value="{{ $visited_id }}">
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




<br><br>


@endsection
@section('scripts')
  <script src="{{ asset('js/dashboard/profile/user_profile_relationship_not_formed.js') }}"></script>
@stop
