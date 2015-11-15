var albumOrder = (function(pubsub,storageEngine){
  "use strict";

  var _token = document.getElementById("csrf-token").value;
  var _albumID = document.getElementById("albumID").value;
  var _orderID = document.getElementById("orderID").value;

  pubsub.subscribe("pageChanged", _checkOrder);
  pubsub.subscribe("photoSelected", _addToOrder);
  pubsub.subscribe("photoUnselected", _deleteFromOrder);

  //Initializes local DB.  If DB already exists it clears it out.
  //If this is an edit order then we load previous order into local DB
  storageEngine.init(function(){
			storageEngine.initObjectStore("photos",function(){
				storageEngine.clearAll("photos",function(){
          if(_orderID!=''){
            //load selected photos to local DB
            var data = {_token:_token, orderID:_orderID};
            var hr = new XMLHttpRequest();
        		hr.open("POST","/load/ordered_album",false);
        		hr.setRequestHeader("Content-type", "application/json");
        		hr.onreadystatechange = function(){
        			if(hr.readyState == 4 && hr.status == 200){
        				var selectedPhotos = JSON.parse(hr.responseText);
                var length = selectedPhotos.length;
      					var list = [];
      					for(var j = 0; j < length; j++){
      						list.push({id: j.toString(), photo_id: selectedPhotos[j].client_album_photo_id.toString()});
      					}
                storageEngine.saveList("photos",list,function(){
                  pubsub.publish("orderLoaded",length);
                });
        			}
        		};//end hr.onreadystatechange
        		hr.send(JSON.stringify(data));
          }//end if
	})})});//end sorageEngine init

  document.getElementById("submit_order").addEventListener("click",function(){
    _submitOrder();
  });

  function _addToOrder(photoID){
    storageEngine.save("photos",{photo_id: photoID.toString()},function(){});
  }

  function _deleteFromOrder(photoID){
    storageEngine.findByProperty("photos","photo_id",photoID.toString(),function(result){
      storageEngine.delete("photos",result[0].id,function(){});
    });
  }

  //Checks all photos on page are in order
  //Addes new property isInOrder to every photo object
  //Calls pubsub to notify that photo was checked
  function _checkOrder(photos){
    var length = photos.length;
    var photo = {};

    for(var i = 0; i < length; i++){
      photo = photos[i];
      storageEngine.findByProperty("photos","photo_id",photo.id.toString(),function(result){
          if(result.length > 0){
            this.isInOrder = true;
          }
          else{
            this.isInOrder = false;
          }
          pubsub.publish("addedPropertyisInOrderToPhoto",this);
        }.bind(photo)
      );
    }
  }

  function _submitOrder(){
    storageEngine.findAll("photos",function(photos){
			if(photos.length ==0){
				alert("Cannot submit an order with no photos selected");
			}
			else{
				var data = {photos:photos,album_id:_albumID,order_id: _orderID};
				$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': _token
		        }});
				$.ajax({
					type: "POST",
					url: "/submit/album_purchase",
					data: data,
					success: function(){
            if(_orderID ==''){
              //after order has been submited
    					//redirect customer to page of order completion
    					document.location.href = "http://"+document.domain+"/user/dashboard";
            }
            else{
              location.reload();
            }

			      }});
      }//end else
		});
  }
})(pubsub, storageEngine);
