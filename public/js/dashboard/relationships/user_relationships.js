$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

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
    $('#form-relationship-option-' + $(this).data('user')).fadeIn(500);
    $('#form-relationship-hr-' + $(this).data('user')).fadeIn(500);
    // alert($(this).data('user'));
  });

  $(document).on('click', '.form-relationship-cancel-btn', function() {
    // $('#form-relationship-option-' + $(this).data('user')).css("display", "none");
    $('#form-relationship-option-' + $(this).data('user')).fadeOut();
    // $('#form-relationship-hr-' + $(this).data('user')).css("display", "none");
    $('#form-relationship-hr-' + $(this).data('user')).fadeOut();
  });

  $(document).on('click', '.form-relationship-final-btn', function() {

    let responder_id = $(this).data('user');
    let relationship_id = $("#relationship-id-" + responder_id).val();
    let html = $('#search_results_wrapper').html();
    $('#user-result-wrapper-' + responder_id).html("<h4>Please wait...</h4><hr>");

    let data = {};
    data.responder_id = responder_id;
    data.relationship_id = relationship_id;


    $.ajax({
      type: "POST",
      url: "form_relationship",
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
});
