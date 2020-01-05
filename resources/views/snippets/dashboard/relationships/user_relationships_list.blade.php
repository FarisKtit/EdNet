@if(count($relationships) == 0)
  <h5>You have no relationships! start searching!</h5>
@else
  @foreach($relationships as $r)
    @if($r->friend_id != auth()->user()->id)
      <div class="row">
        <div class="col-md-2">
          <img src="/storage/{{ $r->profile_image_thumbnail_filename }}" class="img-thumbnail" alt="">
        </div>
        <div class="col-md-4 relationship_member_info">
          <h4>{{ $r->name }}</h4>
          <p>{{ $r->occupation }}</p>
        </div>
        <div class="col-md-6">

          <div class="row">
            <div class="col-md-12">
              <a href="{{ route('view_user_profile', $r->friend_id) }}"><u><p>View Profile</p></u></a>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <u><p class="delete_relationship_btn" data-name="{{ $r->name }}" data-user="{{ $r->friend_id }}">Delete Relationship</p></u>
            </div>
          </div>

        </div>

      </div>
      <hr>

    @endif
  @endforeach
@endif
