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

  //=====Paginate
  $(document).on('click', '#pagination a', function(e) {
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1];
    get_user_posts(page);
  });

  //=====Like a post
  $(document).on('click', '.like-btn', function() {
    let btn = $(this);
    let post_id = btn.data('post');
    btn.attr('disabled', 'disabled');
    let data = {};
    data.post_id = post_id;

    $.ajax({
      type: "POST",
      url: "/add_like_to_post",
      data: data
    }).done(function(data) {
      console.log(data);
      if(data.status == 'success') {
        $('#like-btn-' + post_id + '-wrapper').html('<button type="button" style="width: 100%;" class="btn btn-sm btn-default un-like-btn" id="un-like-btn-'+ post_id +'" data-post="' + post_id + '" name="button">Unlike</button>');
        $("#like-count-" + post_id).html(data.count + " Likes");
      } else {
        btn.removeAttr('disabled');
      }
    }).fail(function(jqXHR, status, err) {
      btn.removeAttr('disabled');
    });
  });

  //=====Unlike a post
  $(document).on('click', '.un-like-btn', function() {
    let btn = $(this);
    let post_id = btn.data('post');
    btn.attr('disabled', 'disabled');
    let data = {};
    data.post_id = post_id;

    $.ajax({
      type: "POST",
      url: "/remove_like_from_post",
      data: data
    }).done(function(data) {
      console.log(data);
      if(data.status == 'success') {
        $('#like-btn-' + post_id + '-wrapper').html('<button type="button" style="width: 100%;" class="btn btn-sm btn-default like-btn" id="like-btn-'+ post_id +'" data-post="' + post_id + '" name="button">Like</button>');
        $("#like-count-" + post_id).html(data.count + " Likes");
      } else {
        btn.removeAttr('disabled');
      }
    }).fail(function(jqXHR, status, err) {
      btn.removeAttr('disabled');
    });
  });

  //=====Show comments
  $(document).on('click', '.comment-btn', function() {
    let btn = $(this);
    let post_id = btn.data('post');
    let data = {};
    data.post_id = post_id;
    btn.attr('disabled', 'disabled');

    $.ajax({
      type: "GET",
      url: "/get_all_comments_for_post",
      data: data
    }).done(function(data) {
      console.log(data);
      if(data.status == "success") {
        $("#toggle-comments-btns-wrapper-" + post_id).html('<button type="button" class="btn btn-sm btn-default hide-comment-btn" data-post="' + post_id + '" id="hide-comment-btn-' + post_id + '" name="button">Hide Comments</button>');
        $("#post-comments-" + post_id).html(data.html);
      }
    }).fail(function(jqXHR, status, err) {

    });
  });

  //=====Hide comments
  $(document).on('click', '.hide-comment-btn', function() {
    let btn = $(this);
    let post_id = btn.data('post');
    btn.attr('disabled', 'disabled');
    $("#post-comments-" + post_id).html("");
    $("#toggle-comments-btns-wrapper-" + post_id).html('<button type="button" class="btn btn-sm btn-default comment-btn" data-post="' + post_id + '" id="comment-btn-' + post_id + '" name="button">Show Comments</button>');

  });

  //=====Add comment to post modal
  $(document).on('click', '.add-comment-btn', function() {
    let post_id = $(this).data('post');
    $('#add_comment_to_post_content').val("");
    $('#add_comment_to_post_submit_btn').data('post', post_id);

    $('.add-comment-to-post-gif').css('display', 'none');
    $('.add-comment-to-post-complete-screen').css('display', 'none');
    $('.add-comment-to-post-form').css('display', 'block');

    $('.add_comment_to_post_modal').css('display', 'block');
  });

  //=====Cancel Add comment to post modal
  $(document).on('click', '.cancel-add-comment-screen-btn, .add-comment-to-post-complete-screen-close-btn', function() {
    $('.add_comment_to_post_modal').css('display', 'none');
  });

  //======Add comment to post submit
  $(document).on('click', '#add_comment_to_post_submit_btn', function() {
    let comment = $('#add_comment_to_post_content').val();
    let post_id = $(this).data('post');

    let data = {};
    data.content = comment;
    data.post_id = post_id;

    $('.add-comment-to-post-form').css('display', 'none');
    $('.add-comment-to-post-complete-screen').css('display', 'none');
    $('.add-comment-to-post-gif').css('display', 'block');

    $.ajax({
      type: 'POST',
      url: '/add_comment_to_post',
      data: data
    }).done(function(data) {
      if(data.status == 'success') {
        $('.add-comment-to-post-complete-msg').text("Comment successfully added.");
        $('.add-comment-to-post-complete-msg').css('color', 'green');
      } else {
        $('.add-comment-to-post-complete-msg').text("Error, please try again later.");
        $('.add-comment-to-post-complete-msg').css('color', 'red');
      }

      $('.add-comment-to-post-form').css('display', 'none');
      $('.add-comment-to-post-gif').css('display', 'none');
      $('.add-comment-to-post-complete-screen').css('display', 'block');

    }).fail(function(jqXHR, status, err) {
      $('.add-comment-to-post-complete-msg').text("Error, please try again later.");
      $('.add-comment-to-post-complete-msg').css('color', 'red');

      $('.add-comment-to-post-form').css('display', 'none');
      $('.add-comment-to-post-gif').css('display', 'none');
      $('.add-comment-to-post-complete-screen').css('display', 'block');
    });
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
