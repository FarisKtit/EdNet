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
    alert($(this).data('user'));
  });
});
