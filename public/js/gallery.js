function gallery(pubsub){
  var that = {};
  that._enlargePhoto = document.getElementById("enlarge-photo");
  that._resultsBox = document.getElementById("results_box");

  //sets the enlarge-photo source when client clicks the magnify icon
  that._zoomInEvent = function(e){
    var img = e.target.nextSibling;
		that._enlargePhoto.src = img.src;
  };

  that._clearGallery = function(){
    that._resultsBox.innerHTML = "";
  };

  pubsub.subscribe("fetchingPhotos", that._clearGallery);

  //Closes enlarged photo when user clicks on the enlarged photo
  document.getElementById("myModal").addEventListener("click",function(){
    $('#myModal').foundation('reveal', 'close');
  });

  return that;
}
