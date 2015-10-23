<script>
	var itemsPerPage = {{ $itemsPerPage }};
	var last = {{ $last }};
    var albumID = {{ $albumID }};
	var DOMAINNAME = "{{ url().'/' }}";
	var token = "{{ csrf_token() }}";
	var json = '{{ $photo_formats }}';
    json = replaceAll("&quot;","\"",json);
    var formats = JSON.parse(json);
	
	/**
		Finds a string of characters within a string and 
		replaces all instances with new string.
	*/
	function replaceAll(find, replace, str) {
  		return str.replace(new RegExp(find, 'g'), replace);
	}

	/**
		Loads image into popup window
	*/
	var zoomInEvent = function(e){
		var $img = $(e.target).next();
		$("#enlarge-photo").attr("src",$img.attr("src"));
	}

	/**
		A Click Event that deletes a format and quantity from page and
		local storage database 
	*/
	var clickDeleteButtonEvent = function(e){
		var $rowDiv = $(e.target).parent().parent();
		var $pictureDiv = $rowDiv.parent();
		var $deleteSelect = $rowDiv.find("select");
		var $addSelect = $pictureDiv.children().last().find("select");

		var photoID = $pictureDiv.attr('id');
		var formatID = parseInt($deleteSelect.val());
		var formatText = $deleteSelect.text();

		storageEngine.findByProperty("photo_prints","photo_id",photoID,function(result){
			var id = 0;
			var length = result.length;

			//find the id value in local database
			for(var i = 0; i < length && !(id); i++){
				if(result[i].format_id == formatID)	
					id = result[i].id;
			}

			//delete from database
			storageEngine.delete("photo_prints",id,function(){
				var htmloutput = '<option value="'+formatID+'">'+formatText+'</option>';
				$addSelect.append(htmloutput);//add format to select box
				$rowDiv.remove();//remove delete row
			});
		});//end findByProperty
	}//end clickDeleteButtonEvent

	/**
		A Click Event that adds a format and quantity field to the page and
		local storage database 
	*/
	var clickAddButtonEvent = function(e){
		var $addButton = $(e.target);
		var $rowDiv = $addButton.parent().parent();
		var $pictureDiv = $rowDiv.parent();
		var $qtyInput = $rowDiv.find("input");
		var $formatSelect = $rowDiv.find("select");

		var htmloutput = '';
		var photoID = $pictureDiv.attr('id');
		var formatID = $formatSelect.val();
		var qty = $qtyInput.val();
		var $newRow = {};
		var $deleteButton = {};

		if(formatID ==-1) 
			alert("Select photo format before adding");
		else if(qty===''  || parseInt(qty) < 1)
			alert("Must have a quantity greater then 0");
		else{
			storageEngine.save("photo_prints",{photo_id: photoID,format_id:formatID,quantity:qty},function(result){
				$qtyInput.val(1);
				$formatSelect.find('option:selected').remove();

				htmloutput +=	'<div class="row">';
				htmloutput +=		'<div class="medium-5 large-5 columns">';
				htmloutput += 				'<select class="pictureFormat" disabled="disabled">';
				htmloutput +=					'<option value="'+formatID+'" selected="selected">'+formats[formatID - 1].format+'</option>';
				htmloutput +=				'</select>';
				htmloutput +=		'</div>';
				htmloutput +=		'<div class="medium-2 large-2 columns large-offset-1 picture-quantity-container">';
				htmloutput +=			'<input type="text" class="picture-quantity" disabled="disabled" value="'+qty+'">';
				htmloutput +=		'</div>';
				htmloutput +=		'<div class="medium-2 large-2 columns delete-container large-offset-1">';
				htmloutput += 			'<i class="fa fa-times fa-2x delete-button"></i>';
				htmloutput +=		'</div>';
				htmloutput +=	'</div>';
				$(htmloutput).insertBefore($rowDiv);//add new row before $rowDiv
				$newRow = $rowDiv.prev();
				$deleteButton = $newRow.find("i");
				$deleteButton.on("click",clickDeleteButtonEvent);
			});//end storageEngine save
		
		}//end else
	}//end clickAddButtonEvent

	/**
		Click event lower the photo quantity by one
	*/
	var clickDownButtonEvent = function(e){
		var $qtyInput = $(e.target).parent().next().find("input");
		var picQtyString = $qtyInput.val();
		if(picQtyString == '')
			$qtyInput.val('1');
		else
		{
			var picQty = parseInt(picQtyString);
			if(picQty>1) picQty--;
			$qtyInput.val(picQty);
		}
		
	}

	/**
		Click event raise the photo quantity by one
	*/
	var clickUpButtonEvent = function(e){
		var $qtyInput = $(e.target).parent().prev().find("input");
		var picQtyString = $qtyInput.val();
		if(picQtyString == '')
			$qtyInput.val('1');
		else
		{
			var picQty = parseInt(picQtyString);
			picQty++;
			$qtyInput.val(picQty);
		}
	}

	/**
		Checks that the quantity input are only numbers
	*/
	function isNumber(evt) {
	    evt = (evt) ? evt : window.event;
	    var charCode = (evt.which) ? evt.which : evt.keyCode;
	    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
	        return false;
	    }
	    return true;
	}

	/**
		Parameters:
		photo - the photo object to be added to page
		index - the current photo index (index starts at 1)
		total - the number of photos on the page

		Summary:
		Adds a photo to the page.
	*/
	function addHTMLPhoto(photo,index,total){
		var photoData = {
			photoID: photo.id,
			path: photo.photo_path_low_res,
			index: index,
			total: total
		}
			
			storageEngine.findByProperty("photo_prints","photo_id",photo.id.toString(),function(result){
				var deleteButtons ={};
				var htmloutput = "";
				var flag = true;
				var resultsLength = result.length;
				var formatsLength = formats.length;
				var resultBox = document.getElementById("results_box");
				var currentRow = {};

				//adds a new row to page for every fourth photo
				if(this.index%4==1) {
					htmloutput+='<div class="row"></div>';
					resultBox.insertAdjacentHTML("beforeend", htmloutput);
					htmloutput="";
				}

				currentRow=resultBox.lastChild;

				//Create htmloutput to be added to page
				htmloutput += 	'<div id="'+this.photoID+'" class="photo-container medium-3 large-3 columns end">';
				htmloutput += 		'<span data-reveal-id="myModal"></span>'
				htmloutput +=		'<img src="'+DOMAINNAME + this.path +'" />';

				//add selected formats and quatities with delete button
				for(var i = 0;i < resultsLength; i++){
					htmloutput +=	'<div class="row">';
					htmloutput +=		'<div class="medium-5 large-5 columns">';
					htmloutput += 				'<select class="picture-format" disabled="disabled">';
					htmloutput +=					'<option value="'+formats[result[i].format_id - 1].id+'" selected="selected">'+formats[result[i].format_id - 1].format+'</option>';
					htmloutput +=				'</select>';
					htmloutput +=		'</div>';
					htmloutput +=		'<div class="medium-2 large-2 columns picture-quantity-container large-offset-1">';
					htmloutput +=			'<input type="text" class="picture-quantity" disabled="disabled" value="'+result[i].quantity+'">';
					htmloutput +=		'</div>';
					htmloutput +=		'<div class="medium-2 large-2 columns delete-container large-offset-1">';
					htmloutput += 			'<i class="fa fa-times fa-2x delete-button"></i>';
					htmloutput +=		'</div>';
					htmloutput +=	'</div>';
				}
				htmloutput +=		'<div class="row">';
				htmloutput +=			'<div class="medium-5 large-5 columns">';
				htmloutput += 				'<select class="picture-format">';
				htmloutput +=					'<option value="-1" selected="selected"></option>';

				//adds selection options that client has not already used
				for(var i = 0; i < formatsLength; i++){
					for(var j = 0; j < resultsLength  && flag; j++)
						if(formats[i].id == result[j].format_id) flag = false;
					if(flag)	
						htmloutput +=			'<option value="'+formats[i].id+'">'+formats[i].format+'</option>';
					flag = true;
				}

				htmloutput +=				'</select>';
				htmloutput +=			'</div>';
				htmloutput +=			'<div class="medium-1 large-1 columns arrow-container">';
				htmloutput += 				'<i class="fa fa-caret-down fa-2x down-arrow"></i>';
				htmloutput +=			'</div>';
				htmloutput +=			'<div class="medium-2 large-2 columns picture-quantity-container">';
				htmloutput +=				'<input type="text" class="picture-quantity" onkeypress="return isNumber(event)" onkeypress="return isNumber(event)" value="1">';
				htmloutput +=			'</div>';
				htmloutput +=			'<div class="medium-1 large-1 columns arrow-container">';
				htmloutput += 				'<i class="fa fa-caret-up fa-2x up-arrow"></i>';
				htmloutput +=			'</div>';
				htmloutput +=			'<div class="medium-1 large-2 columns add-container">';
				htmloutput += 				'<i class="fa fa-plus fa-2x add-button">';
				htmloutput +=			'</div>';
				htmloutput +=		'</div>';//end div row
				htmloutput += 	'</div>';//end photo div

				//add htmloutput to page
				currentRow.insertAdjacentHTML("beforeend", htmloutput);

				//add Events to all buttons
				currentRow.lastChild.firstChild.addEventListener("click",zoomInEvent);
				currentRow.lastChild.lastChild.children[1].firstChild.addEventListener("click",clickDownButtonEvent);
				currentRow.lastChild.lastChild.children[3].firstChild.addEventListener("click",clickUpButtonEvent);
				currentRow.lastChild.lastChild.children[4].firstChild.addEventListener("click",clickAddButtonEvent);
				deleteButtons = currentRow.lastChild.getElementsByClassName("delete-button");
				for(var i = 0; i < deleteButtons.length;i++)
					deleteButtons[i].addEventListener("click",clickDeleteButtonEvent);
			}.bind(photoData)); //end storeEngine findByProperty
	}//end addHTMLPhoto function

	/**
		Gets all photos on current requested page and add photos to page
	*/
	function request_page(pn){
		var results_box = document.getElementById("results_box");
		var pagination_controls = document.getElementById("pagination_controls");
		results_box.innerHTML = "loading results ...";
		var hr = new XMLHttpRequest();
		hr.open("POST","/get/album_photos",true);
		hr.setRequestHeader("Content-type", "application/json");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				var photos = JSON.parse(hr.responseText);
				var length = photos.length;

				results_box.innerHTML = "";
				for(var i = 0; i < length; i++){
					addHTMLPhoto(photos[i],i+1,length);
				}
			}//end if
		}//end hr.onreadystatechange
		var data = {_token:token, itemsPerPage:itemsPerPage,last:last, pn:pn,album_id:albumID};
		hr.send(JSON.stringify(data));
		//Add pagination to page
		var count = 0;
		var output= "";
		if(pn>1){
			output += '<li class="arrow"><a onclick="request_page('+(pn-1)+')">&laquo; Previous</a></li>';
		}
		if(pn-4>1){
			output += '<li><a onclick="request_page(1)">'+1+'</a></li>';
			if(pn-4>2)	output += '<li class="unavailable"><a>&hellip;</a></li>';
		}
		for(var i = pn-4;count<4;i++){
			if(i>0) output += '<li><a onclick="request_page('+i+')">'+i+'</a></li>';
			count++;
		}
		output += '<li class="current"><a>'+pn+'</a></li>';
		count = 0;
		for(var i = pn+1;i<=last&&count<4;i++){
			output += '<li><a onclick="request_page('+i+')">'+i+'</a></li>';
			count++;
		}
		if(pn+4 < last){
			if(pn+4<last-1)	output += '<li class="unavailable"><a>&hellip;</a>';
			output += '<li><a onclick="request_page('+last+')">'+last+'</a></li>';
		}
		if(pn<last){
			output += '<li class="arrow"><a onclick="request_page('+(pn+1)+')">Next &raquo;</a></li>';
		}
		pagination_controls.innerHTML = output;
	} //end request_page function

</script>