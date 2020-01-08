@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/profile/user_profile.css') }}" rel="stylesheet">
@stop
@section('content')
<div id="add_comment_to_post_modal" class="add_comment_to_post_modal">

  <div class="add_comment_to_post_modal-content">

    <div class="row add-comment-to-post-form">

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-12">

            <h5>Add comment below.</h5>

          </div>

        </div>

        <div class="row">

          <div class="col-md-3">

          </div>

          <div class="col-md-6">

            <div class="form-group">

              <textarea class="form-control" id="add_comment_to_post_content" rows="3"></textarea>

            </div>


          </div>

          <div class="col-md-3">

          </div>

        </div>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" class="btn btn-sm btn-default" id="add_comment_to_post_submit_btn">Add Comment</button>

          </div>

        </div>

        <br>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" class="btn btn-sm btn-danger cancel-add-comment-screen-btn">Cancel</button>

          </div>

        </div>

      </div>

    </div>

    <div class="row add-comment-to-post-gif" >

      <div class="col-md-12">

        <img src="img/ajax_loader.gif" class="">

        <h4>Adding comment to post..</h4>

      </div>

    </div>

    <div class="row add-comment-to-post-complete-screen" >

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-12">

            <h5 class="add-comment-to-post-complete-msg"></h5>

          </div>

        </div>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" class="btn btn-sm btn-default add-comment-to-post-complete-screen-close-btn">Close Window</button>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<div id="delete_comment_from_post_modal" class="delete_comment_from_post_modal">

  <div class="delete_comment_from_post_modal-content">

    <div class="row delete-comment-from-post-prompt">

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-12">

            <h5>Are you sure you want to delete this comment?</h5>

          </div>

        </div>

        <br>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" data-comment="" data-post="" class="btn btn-sm btn-success" id="delete_comment_from_post_submit_btn">Yes, delete my comment</button>

          </div>



        </div>

        <br>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" class="btn btn-sm btn-danger cancel-delete-comment-screen-btn">No, thanks</button>

          </div>

        </div>

      </div>

    </div>

    <div class="row delete-comment-from-post-gif" >

      <div class="col-md-12">

        <img src="img/ajax_loader.gif" class="">

        <h4>Deleting comment from post..</h4>

      </div>

    </div>

    <div class="row delete-comment-from-post-complete-screen" >

      <div class="col-md-12">

        <div class="row">

          <div class="col-md-12">

            <h5 class="delete-comment-from-post-complete-msg"></h5>

          </div>

        </div>

        <div class="row">

          <div class="col-md-12">

            <button type="button" name="button" class="btn btn-sm btn-default delete-comment-from-post-complete-screen-close-btn">Close Window</button>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>


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
        <form method="post" id="create-post-form" action="{{ route('create_post') }}">
          {{ csrf_field() }}
          <input type="hidden" name="visited_id" id="visited_id" value="{{ auth()->user()->id }}">
          <input type="hidden" name="visitor_id" id="visitor_id" value="{{ auth()->user()->id }}">

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
<br>
<br>

@endsection
@section('scripts')
  <script src="{{ asset('js/dashboard/profile/user_profile.js') }}"></script>
@stop
