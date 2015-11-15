var galleryPaginator = (function(pubsub){
  "use strict";

  var _paginationContainer = document.getElementById("pagination_controls");
  var _token = document.getElementById("csrf-token").value;
  var _itemsPerPage = document.getElementById("itemsPerPage").value;
  var _lastPage = document.getElementById("lastPage").value;
  var _albumID = document.getElementById("albumID").value;

  requestPage(1);

  function _render(pageNumber){
    var count = 0;
    var output= "";
    if(pageNumber>1){
      output += '<li class="arrow"><a onclick="galleryPaginator.requestPage('+(pageNumber-1)+')">&laquo; Previous</a></li>';
    }
    if(pageNumber-4>1){
      output += '<li><a onclick="galleryPaginator.requestPage(1)">'+1+'</a></li>';
      if(pageNumber-4>2)	output += '<li class="unavailable"><a>&hellip;</a></li>';
    }
    for(var i = pageNumber-4;count<4;i++){
      if(i>0) output += '<li><a onclick="galleryPaginator.requestPage('+i+')">'+i+'</a></li>';
      count++;
    }
    output += '<li class="current"><a>'+pageNumber+'</a></li>';
    count = 0;
    for(var i = pageNumber+1;i<=_lastPage&&count<4;i++){
      output += '<li><a onclick="galleryPaginator.requestPage('+i+')">'+i+'</a></li>';
      count++;
    }
    if(pageNumber+4 < _lastPage){
      if(pageNumber+4<_lastPage-1)	output += '<li class="unavailable"><a>&hellip;</a>';
      output += '<li><a onclick="galleryPaginator.requestPage('+_lastPage+')">'+_lastPage+'</a></li>';
    }
    if(pageNumber<_lastPage){
      output += '<li class="arrow"><a onclick="galleryPaginator.requestPage('+(pageNumber+1)+')">Next &raquo;</a></li>';
    }
    _paginationContainer.innerHTML = output;
  }//end _render

  function requestPage(pageNumber){
    var data = {_token:_token, itemsPerPage:_itemsPerPage,last:_lastPage, pn:pageNumber,album_id:_albumID};
    var hr = new XMLHttpRequest();
		hr.open("POST","/get/album_photos",true);
		hr.setRequestHeader("Content-type", "application/json");
		hr.onreadystatechange = function(pageNumber){
			if(hr.readyState == 4 && hr.status == 200){
				var photos = JSON.parse(hr.responseText);
        pubsub.publish("pageChanged", photos);
        _render(pageNumber);
			}
		}.bind(this,pageNumber);//end hr.onreadystatechange
    pubsub.publish("fetchingPhotos", "");
		hr.send(JSON.stringify(data));
  }//end requestPage

  return {
    requestPage:requestPage
  };
})(pubsub);//end galleryPaginator
