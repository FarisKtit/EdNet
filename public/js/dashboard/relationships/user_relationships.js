$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //==Load all users' relationships using pagination
  load_user_relationships();

  //==Search for user to form a relationship

  $(document).on('click', "#search-user-btn", function(e) {
    e.preventDefault();
    let data = {};
    data.name = $('#search-user').val();
    $('input').attr('disabled', 'disabled');

    $.ajax({
      type: "POST",
      url: "/search_users",
      data: data
    }).done(function(data){
      $("input").removeAttr("disabled");
      console.log(data);
      $('#search_results_wrapper').html(data.html);

    }).fail(function(jqXHR, status, err){
      $("input").removeAttr("disabled");
      console.log(err);
    });
  });

  //==Form a relationship with a user in the search results

  $(document).on('click', '.form-relationship-btn', function() {
    let responder_id = $(this).data('user');
    let html = $('#search_results_wrapper').html();
    $('#user-result-wrapper-' + responder_id).html("<h4>Please wait...</h4><hr>");

    let data = {};
    data.responder_id = responder_id;

    $.ajax({
      type: "POST",
      url: "/form_relationship",
      data: data
    }).done(function(data) {
      $('#user-result-wrapper-' + responder_id).css('display', 'none');
      if(data.status == 'success') {
        $('#user-result-wrapper-' + responder_id).html("<h5 style='color:blue;'>Relationship request was sent<br>Please await their response</h5><hr>");
      } else {
        $('#user-result-wrapper-' + responder_id).html("<h5 style='color:red;'>Error, please try again later</h5><hr>");
      }
      $('#user-result-wrapper-' + responder_id).fadeIn(500);
    }).fail(function(jqXHR, status, err){
      $('#user-result-wrapper-' + responder_id).css('display', 'none');
      $('#user-result-wrapper-' + responder_id).html("<h5 style='color:red;'>Error, please try again later</h5><hr>");
      $('#user-result-wrapper-' + responder_id).fadeIn(500);
    });
  });



  //==Accept a relationship request
  $(document).on('click', '.accept-request-btn', function() {
    let $relationship = $(this).data('user');
    let data = {};
    data.relationship_id = $relationship;
    $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5>Please wait...</h5></div>");
    $.ajax({
      type: "POST",
      url: "accept_relationship",
      data: data
    }).done(function(data) {
      if(data.status == 'success') {
        $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: blue;'>Relationship successfully formed</h5></div>");
        $("#show_relationships").css('display', 'none');
        $("#load_relationships").css('display', 'block');
        load_user_relationships();
      } else {
        $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: red;'>Error, try again later</h5></div>");
      }
    }).fail(function(jqXHR, status, err) {
      $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: red;'>Error, try again later</h5></div>");
    });

  });


  //==Reject a relationship request
  $(document).on('click', '.reject-request-btn', function() {
    let $relationship = $(this).data('user');
    let data = {};
    data.relationship_id = $relationship;
    $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5>Please wait...</h5></div>");
    $.ajax({
      type: "POST",
      url: "reject_relationship",
      data: data
    }).done(function(data) {
      if(data.status == 'success') {
        $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: blue;'>Relationship successfully rejected</h5></div>");
      } else {
        $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: red;'>Error, try again later</h5></div>");
      }
    }).fail(function(jqXHR, status, err) {
      $('#requester-info-wrapper-' + $relationship).html("<div class='col-md-12'><h5 style='color: red;'>Error, try again later</h5></div>");
    });
  });

  //==Delete user relationship
  $(document).on('click', '.delete_relationship_btn', function() {
    let user_id_to_delete = $(this).data('user');
    let user_name_to_delete = $(this).data('name');
    $("#delete_relationship_modal_question").html("Are you sure you want to delete your relationship with " + user_name_to_delete);
    $('#delete_relationship_confirm_btn').data('user', user_id_to_delete);

    $(".delete_relationship_gif_screen").css('display', 'none');
    $(".delete_relationship_complete_screen").css('display', 'none');
    $(".delete_relationship_modal_question_screen").css('display', 'block');

    $('#delete_relationship_modal').css('display', 'block');
  });

  $(document).on('click', '#delete_relationship_confirm_btn', function() {
    let user_id_to_delete = $(this).data('user');
    let data = {};
    data.user_id_to_delete = user_id_to_delete;

    $(".delete_relationship_complete_screen").css('display', 'none');
    $(".delete_relationship_modal_question_screen").css('display', 'none');
    $(".delete_relationship_gif_screen").css('display', 'block');

    $.ajax({
      type: "POST",
      url: "/delete_relationship",
      data: data
    }).done(function(data) {

      if(data.status == "success") {
        $("#delete_relationship_complete_screen_msg").css('color', 'green');
        $("#delete_relationship_complete_screen_msg").html("User successfully deleted.");
      } else {
        $("#delete_relationship_complete_screen_msg").css('color', 'red');
        $("#delete_relationship_complete_screen_msg").html("Error occurred, please try again later.");
      }
      $("#show_relationships").css('display', 'none');
      $("#load_relationships").css('display', 'block');
      load_user_relationships();

      $(".delete_relationship_modal_question_screen").css('display', 'none');
      $(".delete_relationship_gif_screen").css('display', 'none');
      $(".delete_relationship_complete_screen").css('display', 'block');
    }).fail(function(jqXHR, status, err) {
      $("#delete_relationship_complete_screen_msg").css('color', 'red');
      $("#delete_relationship_complete_screen_msg").html("Error occurred, please try again later.");

      $("#show_relationships").css('display', 'none');
      $("#load_relationships").css('display', 'block');
      load_user_relationships();

      $(".delete_relationship_modal_question_screen").css('display', 'none');
      $(".delete_relationship_gif_screen").css('display', 'none');
      $(".delete_relationship_complete_screen").css('display', 'block');
    });
  });

  $(document).on('click', '#delete_relationship_complete_screen_close_btn, #delete_relationship_cancel_btn', function(){
    $('#delete_relationship_modal').css('display', 'none');
  });
});

function load_user_relationships() {
  $.ajax({
    type: "GET",
    url: "/get_relationships"
  }).done(function(data) {
    setTimeout(function() {
      $('#load_relationships').css('display', 'none');
      if(data.status == 'success') {
        $('#show_relationships').html(data.html);
      } else {
        $('#show_relationships').html('<h4>Error loading relationships</h4>');
      }
      $('#show_relationships').css('display', 'block');
    }, 1000);
  }).fail(function(jqXHR, status, err) {
    $('#load_relationships').css('display', 'none');
    $('#show_relationships').html('<h4>Error loading relationships</h4>');
    $('#show_relationships').css('display', 'block');

  });
}
