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
      <div class="row">
        <div class="col-md-12">
          <p>{{ $comment->content }}</p>
        </div>
      </div>
      <div class="row align-items-end post-comment-btns-wrapper">
        <div class="col-md-4">
          <h6 class="" id="like-count-{{ $comment->id }}">{{ count($comment->post_comment_likes) }} likes</h6>
        </div>
        <div class="col-md-4">
          @if($comment->post_comment_likes->contains('user_id', auth()->user()->id))
            <u><h6 class="unlike-comment-btn" data-comment="{{ $comment->id }}" data-post="{{ $comment->post_id }}" id="unlike-comment-btn-{{ $comment->id }}">Unlike comment</h6></u>
          @else
            <u><h6 class="like-comment-btn" data-comment="{{ $comment->id }}" id="like-comment-btn-{{ $comment->id }}">Like comment</h6></u>
          @endif
        </div>
        <div class="col-md-4">
          @if($comment->user->id == auth()->user()->id)
          <u><h6 class="delete-comment-btn" data-post="{{ $comment->post_id }}" data-comment="{{ $comment->id }}" id="delete-comment-btn-{{ $comment->id }}" style="color: red;">Delete</h6></u>
          @endif
        </div>
      </div>
    </div>
  </div>

  @endforeach
@endif
