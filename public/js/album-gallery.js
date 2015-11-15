var albumGallery = (function(pubsub){
  "use strict";

  var that = gallery(pubsub);

  pubsub.subscribe("counterIncremented",_selectPhoto);
  pubsub.subscribe("addedPropertyisInOrderToPhoto",_renderPhoto);

  //If photo is selected it deselects photo.  If photo is not selected
  //it checks the counter to see if the max amount of photos are selected.
  //If max amount of photos have not been selected _selectPhoto method will
  //be called through pubsub.
  function _clickImgEvent(e){
    var $img = $(e.target);
		var photoID = $img.attr('id');

    if($img.hasClass("selected")){
      $img.toggleClass("selected");
      pubsub.publish("photoUnselected", photoID);
    }
    else{
      //If counter can be incremented, counter mocule will publish
      //event "counterIncremented" that will call function _selectPhoto
      pubsub.publish("incrementCounter", $img);
    }
  }

  function _selectPhoto($img){
    var photoID = $img.attr('id');
    $img.addClass("selected");
    pubsub.publish("photoSelected", photoID);
  }

  function _renderPhoto(photo){
		var htmloutput = "";
		var photoContainer = {};

		htmloutput += 	'<div class="photo-container medium-3 large-3 columns end">'
							+'<span data-reveal-id="myModal"></span><img id="'+photo.id+'"';
		if(photo.isInOrder){
			htmloutput+=	' class="selected';
		}
		htmloutput+= 		'" src="/'+photo.photo_path_low_res+'" /></div>';
		that._resultsBox.insertAdjacentHTML("beforeend", htmloutput);
		photoContainer = that._resultsBox.lastChild;

		//Add events to for zoom and selecting photos for album.
		photoContainer.firstChild.addEventListener("click",that._zoomInEvent);
		photoContainer.lastChild.addEventListener("click",_clickImgEvent);
	}
})(pubsub);
