<div class="row" id="pending-relationship-requests">
  <div class="col-md-12">
    @if(count($requests) == 0)
      <div class="row">
        <div class="col-md-12">
          <h4>No pending requests.</h4>

        </div>

      </div>
    @else
      @foreach($requests as $request)
        <div class="row requester-info-wrapper" id="requester-info-wrapper-{{ $request->id }}">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-12">
                <img src="storage/{{ $request->profile_image_thumbnail_filename }}" class="img-thumbnail" alt="">
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4>{{ $request->name }}</h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h5>{{ $request->occupation }}</h5>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <h5>{{ $request->requester_question }}</h5>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <u><p class="accept-request-btn" data-user="{{ $request->id }}">Accept request</p></u>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <u><p class="reject-request-btn" data-user="{{ $request->id }}">Reject request</p></u>
              </div>
            </div>

          </div>
        </div>
        <hr>
      @endforeach
    @endif
  </div>

</div>
