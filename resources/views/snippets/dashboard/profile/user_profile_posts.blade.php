@if(count($posts) == 0)
  <div class="row">
    <div class="col-md-12">
      <h5>No posts!</h5>
    </div>

  </div>
@else
  @foreach($posts as $post)
    <div class="row user-posts">
      <div class="col-md-12 user-post">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-3 user-post-img">
                <br>
                <img src="/storage/{{ $post->user->profile_image_thumbnail_filename }}" class="img-thumbnail" alt="">

              </div>
              <div class="col-md-9">
                <h3>{{ $post->user->name }}</h3>
                <h5>{{ $post->user->occupation->name }}</h5>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <h5><b>Created at:</b> {{ $post->created_at }}</h5>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 user-post-content">
            <p class="">{{ $post->content }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4" id="like-btn-{{ $post->id }}-wrapper">
            @if($post->likes->contains('user_id', auth()->user()->id))
              <button type="button" style="width: 100%;" class="btn btn-sm btn-default un-like-btn" id="un-like-btn-{{ $post->id }}" data-post="{{ $post->id }}" name="button">Unlike</button>
            @else
              <button type="button" class="btn btn-sm btn-default like-btn" id="like-btn-{{ $post->id }}" data-post="{{ $post->id }}" name="button">Like</button>
            @endif
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-sm btn-default add-comment-btn" data-post="{{ $post->id }}" id="create-comment-btn-{{ $post->id }}" name="button">Add Comment</button>
          </div>
          <div class="col-md-4" id="toggle-comments-btns-wrapper-{{ $post->id }}">
            <button type="button" class="btn btn-sm btn-default comment-btn" data-post="{{ $post->id }}" id="comment-btn-{{ $post->id }}" name="button">Show Comments</button>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">

             <p id="like-count-{{ $post->id }}">{{ count($post->likes) }} Likes</p>

          </div>
          <div class="col-md-4">

          </div>
          <div class="col-md-4">

            <p id="comment-count-{{ $post->id }}">{{ count($post->post_comments) }} Comments</p>

          </div>
        </div>

        <div class="row post-comments-wrapper">
          <div class="col-md-12" id="post-comments-{{ $post->id }}">

          </div>
        </div>



      </div>
    </div>
    <hr>
  @endforeach
  <div id="pagination">
    {{ $posts->links() }}
  </div>
@endif
