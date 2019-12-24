$(document).ready(function() {
  let toggled = false;
  $("#toggle-menu").on('click', function(e) {
    e.preventDefault();
    $("div#wrapper.d-flex").toggleClass("toggled");
    if(toggled == false) {
      $("#toggle-menu").html('Open Menu &nbsp<i class="fas fa-arrows-alt-h"></i>');
      toggled = true;
    } else {
      $("#toggle-menu").html('Close Menu &nbsp<i class="fas fa-arrows-alt-h"></i>');
      toggled = false;
    }
  });
});
