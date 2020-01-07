@if(count($comments) == 0)

  <hr>
  <div class="row">
    <div class="col-md-12">
      <h5>No comments.</h5>
    </div>
  </div>

@else
  @foreach($comments as $comment)

  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-11">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-1">

    </div>
    <div class="col-md-1 post-comment-image-wrapper">
      <img src="/storage/{{ $comment->user->profile_image_thumbnail_filename }}" class="img-thumbnail post-comment-image" alt="">

    </div>
    <div class="col-md-3 post-comment-info-wrapper">
      <h5>{{ $comment->user->name }}</h5>
      <h6>{{ $comment->created_at }}</h6>
    </div>
    <div class="col-md-7">
      <p>{{ $comment->content }}</p>
    </div>
  </div>

  @endforeach
@endif
