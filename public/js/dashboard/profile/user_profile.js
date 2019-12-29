$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#user-post-btn').on('click', function(e) {
    e.preventDefault();
    let post = $('#post').val();
    let visitor_id = $('#visitor_id').val();
    let visited_id = $('#visited_id').val();
    $('#user-post-btn').attr('disabled', 'disabled');
    $('#post').attr('disabled', 'disabled');
    var data = {};
    data.visitor_id = visitor_id;
    data.visited_id = visited_id;
    data.content = post;

    $.ajax({
      type: "POST",
      url: "/create_post",
      data: data
    }).done(function(data) {
      $('#user-post-btn').removeAttr('disabled');
      $('#post').removeAttr('disabled');
      console.log(data);
      if(data.status == 'success') {
        $('#post-creation-success-alert').css('display','block');
        $('#user-profile-posts').html(data.html);
        $('#post').val('');
      } else {
        $('#post-creation-error-alert').css('display','block');
      }


    }).fail(function(jqXHR, status, err) {
      $('#user-post-btn').removeAttr('disabled');
      $('#post').removeAttr('disabled');
      $('#post-creation-error-alert').css('display','block');

    });
  });
});
