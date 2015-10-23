
$(document).ready(function(){
	$('#loading-cont').hide();
    var executing = false;

    $( "#submit" ).click(function() 
    {
    	$('#loading-cont').show();
        var csrf = $("meta[name='csrf-token']").attr("content");
        var request = new XMLHttpRequest();
        
        // reloads the page when an xmlhttprequest 
        // was successfully sent to database
        request.onreadystatechange=function(v)
        {
            
            if(request.readyState==4 &&request.status==200) {
	        $('#loading-cont').hide();
                location.reload(true);
            }
        }

        if(formValidate() && !executing)
        {
            executing = true;
            var fd = new FormData($("#form_add_photos")[0]);
            request.open("POST", "/submit/album_photos");
            request.setRequestHeader('X-CSRF-TOKEN',csrf);
            request.send(fd);
        }
                
    });

    function formValidate()
    {
        var files = $("#img-input").val();
        var result = true;
        if(!files)
        {
            result = false;
            $("#file-error").removeClass("valid");
        }
        return result;
    }

});