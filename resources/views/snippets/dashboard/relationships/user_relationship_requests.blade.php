@if(count($requests) == 0)
  <div class="row">
    <div class="col-md-12">
      <h4>No pending requests.</h4>

    </div>

  </div>
@else
  @foreach($requests as $request)
    @if($request->requester_id == auth()->user()->id)
      <h5>Awaiting response</h5>
    @else
      <h5>Accept request</h5>
      <h5>Decline request</h5>
    @endif
  @endforeach
@endif
