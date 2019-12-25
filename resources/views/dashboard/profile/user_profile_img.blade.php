@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile_img.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.Jcrop.css') }}" rel="stylesheet">
@stop
@section('content')
<div class="row">
  <div class="col-md-4">
    <a href="{{ route('edit_profile') }}"><button type="button" class="btn btn-md btn-default" name="button">Back</button></a>
  </div>
  <div class="col-md-4 profile-image-title">
    <div class="row">
      <div class="col-md-12">
        <h3>Please select a file to upload</h3>
        <form method="post">
          <input type="hidden" id="x1" name="x1">
          <input type="hidden" id="x2" name="x2">
          <input type="hidden" id="y1" name="y1">
          <input type="hidden" id="y2" name="y2">
          <input type="hidden" id="w" name="w">
          <input type="hidden" id="h" name="h">
          <div class="form-group">
            <input type="file" class="form-control-file" onchange="display_uploaded_image(this);" name="profile-img" id="profile-img">
          </div>
          <p class="profile-image-upload-msg">Your image should appear below, if you are happy with the image, just press the <b>"Upload Photo" button below</b>.</p>
          <p class="profile-image-upload-msg">If you would like to crop it, select the area on the image with your mouse that you would like to upload then press the <b>"Upload Photo" button below</b>.</p>


          <button type="submit" class="btn btn-default profile-image-upload-btn">Upload Photo</button>
        </form>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <img src="..." alt="..." id="profile-image-to-upload" class="">
      </div>
    </div>

  </div>
  <div class="col-md-4">
  </div>
</div>
<div class="row">


</div>
@endsection
@section('scripts')
  <script src="{{ asset('js/jquery.Jcrop.js') }}"></script>
  <script src="{{ asset('js/dashboard/profile/user_profile_img.js') }}"></script>

@stop
