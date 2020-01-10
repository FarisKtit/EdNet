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
              <div class="col-md-6 user-post-img">
                <br>
                <img src="/storage/{{ $post->poster_img }}" class="img-thumbnail" alt="">
                <h5>Poster {{ $post->poster }}</h5>
              </div>
              <div class="col-md-6 user-post-img">
                <br>
                <img src="/storage/{{ $post->receiver_img }}" class="img-thumbnail" alt="">
                <h5>Receiver {{ $post->receiver }}</h5>
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
              <button type="button" class="btn btn-sm btn-default like-btn" id="like-btn-{{ $post->id }}" data-post="{{ $post->id }}" name="button">Like</button>
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

             <p id="like-count-{{ $post->id }}">{{ \App\Like::where('post_id', '=', $post->id)->get()->count() }} Likes</p>

          </div>
          <div class="col-md-4">

          </div>
          <div class="col-md-4">

            <p id="comment-count-{{ $post->id }}">{{ \App\PostComment::where('post_id', '=', $post->id)->get()->count() }} Comments</p>

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
