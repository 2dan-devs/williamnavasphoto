 
    var executing = false;
    //creates new client album if form data is valid
    
    function submitAlbum(){
        var csrf = $("meta[name='csrf-token']").attr("content");
        
        var request = new XMLHttpRequest();
        var route = document.URL;
        //reloads the page when an xmlhttprequest 
        //was successfully sent to database
        request.onreadystatechange=function()
        {
            if (request.readyState==4 && request.status==200)
                location.reload(true);
        }

        if(formValidation() && !executing)
        {
            executing = true
            var fd = new FormData($("#form_client_album")[0]);
            request.open("POST", route);
            request.setRequestHeader('X-CSRF-TOKEN',csrf);
            request.send(fd);
        }      
    }

    //validates form data.  Returns true if valid and false if not valid
    function formValidation()
    {
        var result = true;

        //data from form to be validated
        var file = $("#img-input").val();
        var albumName = $("#album_name").val();
        var max = $("#photo_selection_max").val();

        if(file)
        {
            $("#file-error").addClass("valid");
        }
        else
        {
            $("#file-error").removeClass("valid");
            result = false;
        }

        if(albumName.length>2 && albumName.length<26)
        {
            $("#name-error").addClass("valid");
        }
        else
        {
            $("#name-error").removeClass("valid");
            result = false;
        }

        if(max && isInt(max))
        {
            $("#max-error").addClass("valid");
        }
        else
        {
            $("#max-error").removeClass("valid");
            result = false;
        }

        return result;

    }

    function isInt(n) 
    {
        return n % 1 === 0;
    }

$(document).ready(function(){
    
    $("#albums-container div:last-child").addClass("end");

    $( "#submit" ).click(function(event) 
    {
        event.preventDefault();
        submitAlbum();
    });

    

	// Album cover photo preview.
	function imgPreview(input){
    	if(input.files && input.files[0]) {
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
