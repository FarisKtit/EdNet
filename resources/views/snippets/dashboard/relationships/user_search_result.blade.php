<div class="row">
  <div class="col-md-12">
    @if(count($users) == 0)
    <div class="row">
      <div class="col-md-12">
        <h5>No users found.</h5>

      </div>

    </div>
    @else
      @foreach($users as $user)

        <div class="row">
          <div class="col-md-4">
            <img src="storage/{{ $user->profile_image_thumbnail_filename }}" class="img-thumbnail" alt="">
          </div>

          <div class="col-md-4">
            <h4>{{ $user->name }}</h4>
            <h5>{{ $user->occupation }}</h5>

          </div>

          <div class="col-md-4">
            @if(is_null($user->accepted))
              <p class="form-relationship-btn" data-user="{{ $user->id }}">Form relationship</p>
            @elseif($user->accepted == 0)
              <p>Awaiting decision</p>
            @else
              <p>Relationship formed</p>
            @endif
            <p class="view-profile-btn" data-profile="{{ $user->id }}">View profile</p>
          </div>

        </div>
        <hr>
      @endforeach
    @endif


  </div>

</div>
