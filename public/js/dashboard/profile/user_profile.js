$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //===Create post on users profile
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
        $('#post').val('');
        get_user_posts(0);

      } else {
        $('#post-creation-error-alert').css('display','block');
      }


    }).fail(function(jqXHR, status, err) {
      $('#user-post-btn').removeAttr('disabled');
      $('#post').removeAttr('disabled');
      $('#post-creation-error-alert').css('display','block');

    });
  });

  // //===Paginate
  $(document).on('click', '#pagination a', function(e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    get_user_posts(page);
  });
});

//function is used to get the users post and upate pagination links
function get_user_posts(page) {
  let current_page = 1;
  if(page != 0) {
    current_page = page;
  }
  let data = {};
  data.visited_id = $('#visited_id').val();
  $.ajax({
    type: "GET",
    url: '/get_user_posts?page=' + page + '',
    data: data
  }).done(function(data) {
    console.log(data);
    if(data.status == 'success') {
      $('#user-profile-posts').html(data.html);
    }

  }).fail(function(jqXHR, status, err) {
    console.log(err);

  });

};
