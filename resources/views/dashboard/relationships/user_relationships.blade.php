@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/relationships/user_relationships.css') }}" rel="stylesheet">
@stop
@section('content')
  <div class="row">
    <div class="col-md-4">
      <u><h4>Search for a user</h4></u>
      <hr>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" id="search-user" name="search-user" placeholder="Add name of user">
        </div>
        <button type="button" class="btn btn-sm btn-default" id="search-user-btn" name="button">Search</button>
      </form>
      <hr>
      <div class="row">
        <div class="col-md-12" id="search_results_wrapper">

        </div>

      </div>
    </div>
    <div class="col-md-4">
      <u><h4>Relationship requests</h4></u>
      <hr>
    </div>
    <div class="col-md-4">
      <u><h4>Relationships</h4></u>
      <hr>
      @if(count($relationships) == 0)
        <h5>You have no relationships! start searching!</h5>
      @else
        @foreach($relationships as $r)
          <p>{{ $r }}</p>
        @endforeach
      @endif
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('js/dashboard/relationships/user_relationships.js') }}"></script>
@stop
