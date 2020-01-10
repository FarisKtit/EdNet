$(document).ready(function() {
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //=====Paginate
  $(document).on('click', '#pagination a', function(e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    get_user_posts(page);
  });

});

//====function is used to get the users post and upate pagination links
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
