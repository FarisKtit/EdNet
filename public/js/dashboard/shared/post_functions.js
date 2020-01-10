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
    get_post_comments(post_id, btn);
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

    let btn_to_lock = $('#comment-btn-' + post_id);

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
        if(btn_to_lock) {
          get_post_comments(post_id, btn_to_lock);
        } else {
          get_post_comments(post_id, undefined);
        }
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

  //======Like comment btn
  $(document).on('click', '.like-comment-btn', function() {
    let post_comment_id = $(this).data('comment');
    let tag = $(this);
    tag.removeClass('like-comment-btn');
    tag.text("Please wait..");
    let data = {};
    data.post_comment_id = post_comment_id;

    $.ajax({
      type: 'POST',
      url: '/add_like_to_post_comment',
      data: data
    }).done(function(data) {
      if(data.status == 'success') {
        $("#like-count-" + post_comment_id).text(data.count + ' likes');
        tag.text("Unlike comment");
        tag.addClass('unlike-comment-btn');
      } else {
        tag.addClass('like-comment-btn');
      }
    }).fail(function(jqXHR, status, err) {
      tag.addClass('like-comment-btn');
    });
  });

  //======Unlike comment btn
  $(document).on('click', '.unlike-comment-btn', function() {
    let post_comment_id = $(this).data('comment');
    let tag = $(this);
    tag.removeClass('unlike-comment-btn');
    tag.text("Please wait..");
    let data = {};
    data.post_comment_id = post_comment_id;

    $.ajax({
      type: 'POST',
      url: '/remove_like_from_post_comment',
      data: data
    }).done(function(data) {
      if(data.status == 'success') {
        $("#like-count-" + post_comment_id).text(data.count + ' likes');
        tag.text("Like comment");
        tag.addClass('like-comment-btn');
      } else {
        tag.addClass('unlike-comment-btn');
      }
    }).fail(function(jqXHR, status, err) {
      tag.addClass('unlike-comment-btn');
    });

  });

  //======Delete comment modal
  $(document).on('click', '.delete-comment-btn', function() {
    let btn = $(this);
    let post_comment_id = $(this).data("comment");

    let post_id = $(this).data('post');

    $("#delete_comment_from_post_submit_btn").data('comment', post_comment_id);
    $("#delete_comment_from_post_submit_btn").data('post', post_id);

    $('.delete-comment-from-post-complete-screen').css('display', 'none');
    $('.delete-comment-from-post-gif').css('display', 'none');
    $(".delete-comment-from-post-prompt").css('display', 'block');

    $("#delete_comment_from_post_modal").css('display', 'block');
  })

  //======Delete comment btn
  $(document).on('click', "#delete_comment_from_post_submit_btn", function() {
    let post_comment_id = $(this).data('comment');
    let post_id = $(this).data('post');

    $('.delete-comment-from-post-complete-screen').css('display', 'none');
    $(".delete-comment-from-post-prompt").css('display', 'none');
    $('.delete-comment-from-post-gif').css('display', 'block');

    let data = {};
    data.post_comment_id = post_comment_id;
    data.post_id = post_id;

    $.ajax({
      type: "POST",
      url: "/delete_comment_from_post",
      data: data
    }).done(function(data) {
      console.log(data);
      if(data.status == 'success') {
        get_post_comments(post_id, undefined);
        $(".delete-comment-from-post-complete-msg").css('color', 'green');
        $(".delete-comment-from-post-complete-msg").text('Comment was successfully deleted!');
      } else {
        $(".delete-comment-from-post-complete-msg").css('color', 'red');
        $(".delete-comment-from-post-complete-msg").text('Error, please try again later.');
      }
      $(".delete-comment-from-post-prompt").css('display', 'none');
      $('.delete-comment-from-post-gif').css('display', 'none');
      $('.delete-comment-from-post-complete-screen').css('display', 'block');

    }).fail(function(jqXHR, status, err) {
      $(".delete-comment-from-post-complete-msg").css('color', 'red');
      $(".delete-comment-from-post-complete-msg").text('Error, please try again later.');
      $(".delete-comment-from-post-prompt").css('display', 'none');
      $('.delete-comment-from-post-gif').css('display', 'none');
      $('.delete-comment-from-post-complete-screen').css('display', 'block');
    });

  })

  //======Cancel Delete comment btn or close window btn
  $(document).on('click', ".cancel-delete-comment-screen-btn, .delete-comment-from-post-complete-screen-close-btn", function() {
    $("#delete_comment_from_post_modal").css('display', 'none');
  });


});


function get_post_comments(post_id, btn) {
  let data = {};
  data.post_id = post_id;
  if(btn != undefined) {
    btn.attr('disabled', 'disabled');
  }

  $.ajax({
    type: "GET",
    url: "/get_all_comments_for_post",
    data: data
  }).done(function(data) {
    console.log(data);
    if(data.status == "success") {
      $('#comment-count-' + post_id).text(data.count + " Comments");
      $("#toggle-comments-btns-wrapper-" + post_id).html('<button type="button" class="btn btn-sm btn-default hide-comment-btn" data-post="' + post_id + '" id="hide-comment-btn-' + post_id + '" name="button">Hide Comments</button>');
      $("#post-comments-" + post_id).html(data.html);
    }
  }).fail(function(jqXHR, status, err) {

  });
}
