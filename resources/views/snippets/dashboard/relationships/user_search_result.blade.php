<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12">
        @if(count($users) == 0 or (count($users) == 1 and $users[0]->id == auth()->user()->id))
        <div class="row">
          <div class="col-md-12">
            <h5>No users found.</h5>

          </div>

        </div>
        @else
          @foreach($users as $user)
            @if($user->id != auth()->user()->id)
              <div id="user-result-wrapper-{{ $user->id }}">
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
                      <u><p class="form-relationship-btn" data-user="{{ $user->id }}">Form relationship</p></u>
                    @elseif($user->accepted == 0)
                      <u><p>Awaiting decision</p></u>
                    @else
                      <u><p>Relationship formed</p></u>
                    @endif
                    <a href="{{ route('view_user_profile', $user->id) }}"><u><p class="view-profile-btn" data-profile="{{ $user->id }}">View profile</p></u></a>
                  </div>

                </div>
                <hr>
                <div class="row form-relationship-option" id="form-relationship-option-{{ $user->id }}">
                  <div class="col-md-6">
                    <p>Please select what sort of relationship you hold.</p>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-12">
                        <select class="form-control form-control-sm" id="relationship-id-{{ $user->id }}" name="relationship-id-{{ $user->id }}">
                          @foreach($relationship_options as $relation)
                            <option value="{{ $relation->id }}">{{ $relation->requester_description }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <br>

                    <div class="row">
                      <div class="col-md-6">
                        <u><p class="form-relationship-final-btn" data-user="{{ $user->id }}">Request relationship</p></u>
                      </div>
                      <div class="col-md-6">
                        <u><p class="form-relationship-cancel-btn" data-user="{{ $user->id }}" id="form-relationship-cancel-{{ $user->id }}">Cancel</p></u>
                      </div>
                    </div>

                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12 form-relationship-hr" id="form-relationship-hr-{{ $user->id }}">
                    <hr>
                  </div>

                </div>
              </div>
            @endif
          @endforeach
        @endif


      </div>

    </div>



  </div>


</div>
