<script>
	var itemsPerPage = {{$itemsPerPage}};
	var last = {{$last}};
	var albumID = {{$albumID}};
    var orderID = {{$orderID}};
	var DOMAINNAME = "{{ url().'/' }}";
	var token = "{{csrf_token() }}";
	var json = replaceAll("&quot;","\"","{{$photosSelected}}");
	selectedPhotos = JSON.parse(json);
	
	function replaceAll(find, replace, str) {
  		return str.replace(new RegExp(find, 'g'), replace);
	}

	var clickImgEvent = function(e){
		var $img = $(e.target) 
		var pictureId = $img.attr('id');
		var counter = parseInt($("#select-counter").html());
		var max = parseInt($("#max-photos").html());
	
		if($img.hasClass("selected")){
			$img.toggleClass("selected");
			storageEngine.findByProperty("photos","photo_id",$img.attr('id'),function(result){
				storageEngine.delete("photos",result[0].id,function(){
					counter--;
					$("#select-counter").text(counter);
				});
			});
		}
		else{
			if(counter<max){
				$img.toggleClass("selected");
				storageEngine.save("photos",{photo_id: $img.attr('id')},function(obj){
					counter++;
					$("#select-counter").text(counter);
				});
			}
			else{
				alert("Cannot select any more photos.  Max amount has been selected.");
			}
		}	
	}
	var zoomInEvent = function(e){
		var $img = $(e.target).next();
		$("#enlarge-photo").attr("src",$img.attr("src"));
	}
	function addHTMLPhoto(photo){
		var data = {
			photoID: photo.id,
			path: photo.photo_path_low_res
		}
			
			storageEngine.findByProperty("photos","photo_id",photo.id.toString(),function(result){
				var htmloutput = "";
				var resultsBox = document.getElementById("results_box");
				var photoContainer = {};

				htmloutput += 	'<div class="photo-container medium-3 large-3 columns end">'
									+'<span data-reveal-id="myModal"></span><img id="'+this.photoID+'"';
				if(result.length){
					htmloutput+=	' class="selected';
				}
				htmloutput+= 		'" src="'+DOMAINNAME+this.path+'" />'
								+'</div>';
				resultsBox.insertAdjacentHTML("beforeend", htmloutput);
				photoContainer = resultsBox.lastChild;

				//Add events to for zoom and selecting photos for album.
				photoContainer.firstChild.addEventListener("click",zoomInEvent);
				photoContainer.lastChild.addEventListener("click",clickImgEvent);
			}.bind(data));
	}

	function request_page(pn){
		var resultsBox = document.getElementById("results_box");
		var pagination_controls = document.getElementById("pagination_controls");
		resultsBox.innerHTML = "loading results ...";
		var hr = new XMLHttpRequest();
		hr.open("POST","/get/album_photos",true);
		hr.setRequestHeader("Content-type", "application/json");
		hr.onreadystatechange = function() {
			if(hr.readyState == 4 && hr.status == 200) {
				var photos = JSON.parse(hr.responseText);
				var length = photos.length;
				resultsBox.innerHTML = "";

				for(var i = 0; i < length; i++){
					addHTMLPhoto(photos[i]);
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