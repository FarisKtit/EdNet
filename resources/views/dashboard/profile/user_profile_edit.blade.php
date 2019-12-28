@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile_edit.css') }}" rel="stylesheet">
@stop
@section('content')
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session()->get('success') }}
      </div>
    @endif
  </div>
  <div class="col-md-4"></div>

</div>
<form method="post" action="{{ route('update_profile') }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="row">
    <div class="col-md-4 profile-edit-upload-img-wrapper">
      <div class="row">
        <div class="col-md-12">
          @if(count($user->profile_image_filename) == 0)
            <img src="img/user.jpg" id="profile-img" class="mx-auto d-block img-thumbnail">
          @else
            <img src="storage/{{ $user->profile_image_filename }}" id="profile-img" class="mx-auto d-block img-thumbnail">
          @endif
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <a href="{{ route('edit_profile_image') }}">Upload New Photo</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <label for="name" class="col-md-4 control-label">Name</label>
            <div class="col-md-12">
              <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">

              @if ($errors->has('name'))
                  <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>
          </div>

        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
            <div class="row">
              <label for="occupation" class="col-md-4 control-label">Occupation</label>
              <div class="col-md-12">
                <select class="form-control form-control-sm" name="occupation">
                  @foreach($occupations as $occupation)
                    @if($occupation->id == $user->occupation_id)
                      <option value="{{ $occupation->id }}" selected>{{ $occupation->name }}</option>
                    @else
                      <option value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                    @endif
                  @endforeach
                </select>

                @if ($errors->has('occupation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('occupation') }}</strong>
                    </span>
                @endif

              </div>
            </div>
        </div>

      </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <label for="birthdate" class="col-md-6 control-label">Date of birth</label>
            <div class="col-md-12">
              <input class="form-control" value="{{ $user->birthdate }}" type="date" placeholder="yyyy-mm-dd" name="birthdate">
                @if ($errors->has('birthdate'))
                    <span class="help-block">
                        <strong>{{ $errors->first('birthdate') }}</strong>
                    </span>
                @endif

            </div>

        </div>

      </div>


    </div>
    <br>
  </div>
  <div class="col-md-4">
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-12">
            <label for="about">About me</label>
            <textarea class="form-control" value="{{ $user->about }}" id="about" name="about" rows="4">{{ $user->about }}</textarea>
          </div>
        </div>
      </div>

    </div>
    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-6">
            <input type="submit" class="btn btn-md btn-default" name="button"/>
          </div>
          <div class="col-md-6">


          </div>

        </div>

      </div>

    </div>

  </div>



</div>
</form>
@endsection
