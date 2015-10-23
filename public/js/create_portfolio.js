    var executing = false;
    
    //creates new client album if form data is valid

    function createPortfolioAlbum()
    {
        var csrf = $('meta[name="csrf-token"]').attr('content');
        var request = new XMLHttpRequest();

        //reloads the page when an xmlhttprequest
        //was successfully sent to database
        request.onreadystatechange=function()
        {
            if (request.readyState===4 && request.status===200)
                location.reload(true);
        }
        if(formValidation() && !executing)
        {
            executing = true;
            var fd = new FormData($("#portfolio_album_form")[0]);
            request.open("POST", "/admin/dashboard/portfolio");
            request.setRequestHeader('X-CSRF-TOKEN',csrf);
            request.send(fd);
        }
        
    }

    //validates form data.  Returns true if valid and false if not valid
    function formValidation()
    {
        var result = true;

        //data from form to be validated
        var portfolioName = $("#name").val();

        if(portfolioName.length>2 && portfolioName.length<26)
        {
            $("#name-error").addClass("valid");
        }
        else
        {
            $("#name-error").removeClass("valid");
            result = false;
        }

        return result;
    }
