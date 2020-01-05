@extends('layouts.dashboard')
@section('styles')
    <link href="{{ asset('css/dashboard/relationships/user_relationships.css') }}" rel="stylesheet">
@stop
@section('content')
  <div id="delete_relationship_modal" class="delete_relationship_modal">

    <div class="delete_relationship_modal-content">
      <div class="row delete_relationship_modal_question_screen">
        <div class="col-md-12">
          <div class="row">

            <div class="col-md-4"></div>
            <div class="col-md-4">
              <h4 id="delete_relationship_modal_question"></h4>
            </div>
            <div class="col-md-4"></div>

          </div>

          <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-6">
                  <u><p id="delete_relationship_confirm_btn">Yes, delete</p></u>
                </div>
                <div class="col-md-6">
                  <u><p id="delete_relationship_cancel_btn">No, cancel</p></u>
                </div>
              </div>
            </div>
            <div class="col-md-4">

            </div>
          </div>

        </div>

      </div>
      <div class="row delete_relationship_gif_screen">
        <img src="img/ajax_loader.gif" id="delete_relationship_gif" class="">
        <h4>Deleting relationship..</h4>
      </div>
      <div class="row delete_relationship_complete_screen">
        <div class="row">
          <div class="col-md-12">
            <h4 id="delete_relationship_complete_screen_msg"></h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <u><p id="delete_relationship_complete_screen_close_btn">Close Window</p></u>
          </div>
        </div>
      </div>
    </div>

  </div>
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
      <div class="row">
        <div class="col-md-12">
          <u><h4>Pending relationship requests</h4></u>
          <hr>
        </div>
      </div>
      @include('snippets.dashboard.relationships.user_relationship_requests')
    </div>
    <div class="col-md-4">
      <u><h4>Relationships</h4></u>
      <hr>
      <div id="load_relationships">
        <img src="img/ajax_loader.gif" id="load_relationships_gif" class="">
        <h4>Loading relationships..</h4>
      </div>
      <div id="show_relationships">

      </div>



    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('js/dashboard/relationships/user_relationships.js') }}"></script>
@stop
