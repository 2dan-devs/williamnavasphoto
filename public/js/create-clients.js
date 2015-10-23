$(document).ready(function(){
	// Profile photo preview.
	function imgPreview(input) {
    	if (input.files && input.files[0]) {
        	var reader = new FileReader()

            reader.onload = function (e) {
                $('#preview-holder').attr('src', e.target.result)
            }
        	reader.readAsDataURL(input.files[0])
    	}
	}

    $("#img-input").change(function(){
        imgPreview(this)
    });


});