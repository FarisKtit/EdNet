@if(count($posts) == 0)
  <div class="row">
    <div class="col-md-12">
      <h5>No posts!</h5>
    </div>

  </div>
@else
  @foreach($posts as $post)
    <div class="row">
      <div class="col-md-12 user-post">
        <div class="row">
          <div class="col-md-6">
            <h3>Poster: {{ $post->poster }}</h3>
            <h5>Receiver: {{ $post->receiver }}</h5>
          </div>
          <div class="col-md-6">
            <h5><b>Created at:</b> {{ $post->created_at }}</h5>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <p class="">{{ $post->content }}</p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-4">
            <button type="button" class="btn btn-sm btn-default like-btn" name="button">Like</button>
          </div>
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
            <button type="button" class="btn btn-sm btn-default comment-btn" name="button">Comment</button>
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
