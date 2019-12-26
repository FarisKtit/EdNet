$(document).ready(function() {

});
function display_uploaded_image(input) {
    if(input.files && input.files[0]) {
      $('.profile-image-upload-msg').css("display", "block");
      $('.profile-image-upload-btn').css("display", "block");

      var reader = new FileReader();

      reader.onload = function(e) {
        $('#profile-image-to-upload').attr('src', e.target.result);
        $('#profile-image-to-upload').css("display", "block");
        $('#profile-image-to-upload').Jcrop({
          onChange: showCoords,
          onSelect: showCoords
        });


      };
      reader.readAsDataURL(input.files[0]);
    }
}

function showCoords(c) {
	$('#x1').val(c.x);
	$('#y1').val(c.y);
	$('#x2').val(c.x2);
	$('#y2').val(c.y2);
	$('#w').val(c.w);
	$('#h').val(c.h);
};
