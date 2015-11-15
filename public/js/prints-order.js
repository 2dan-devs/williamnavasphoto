var printsOrder = (function(pubsub,storageEngine){
  "use strict";

  var _token = document.getElementById("csrf-token").value;
  var _albumID = document.getElementById("albumID").value;
  var _orderID = document.getElementById("orderID").value;

  pubsub.subscribe("clickDeleteButtonEvent",_deleteFromOrder);
  pubsub.subscribe("clickAddButtonEvent",_addToOrder);
  pubsub.subscribe("pageChanged", _checkOrder);

  storageEngine.init(function(){
			storageEngine.initObjectStore("photo_prints",function(){
				storageEngine.clearAll("photo_prints",function(){
          if(_orderID != ''){
            $.ajaxSetup({
    		        headers: {
    		            'X-CSRF-TOKEN': _token
    		    }});

    				$.ajax({
    					type: "POST",
    					url: "/load/ordered_prints",
    					data: {orderID : _orderID},
              async: false,
    					success: function(results){
                var list = [];
                var length = results.length;

                for(var i = 0; i < length; i++){
                  list.push({id: i.toString(), photo_id : results[i].client_album_photo_id.toString(),
                    format_id: results[i].format_id.toString(), quantity : results[i].quantity.toString()});
                }
                storageEngine.saveList("photo_prints",list,function(){});
    				}});//end ajax
          }//end if
  })})});//end StorageEngine init

  function _deleteFromOrder(photo){
    storageEngine.findByProperty("photo_prints","photo_id",photo.photoID,function(results){
			var id = 0;
			var length = results.length;

			//find the id value in local database
			for(var i = 0; i < length && !(id); i++){
				if(results[i].format_id == this.formatID)
					id = results[i].id;
			}
			//delete from local database
			storageEngine.delete("photo_prints",id,function(){});
		}.bind(photo));//end findByProperty
  }

  function _addToOrder(photo){
    storageEngine.save("photo_prints",{photo_id : photo.photo_id, format_id : photo.format_id, quantity: photo.quantity},function(result){});//end storageEngine save
  }

  function _checkOrder(photos){
    var length = photos.length;
    for(var i = 0; i < length; i++){
      photos[i].index = i+1;
      storageEngine.findByProperty("photo_prints","photo_id",photos[i].id.toString(),function(results){
        this.results = results;
        pubsub.publish("checkedOrder", this);
      }.bind(photos[i]));
    }
  }

  $("#submit_order").click(function(e){
		storageEngine.findAll("photo_prints",function(photos){
			if(photos.length ==0){
				alert("Cannot submit an order with no photos selected");
			}
			else{
        var data = {photos:photos,album_id:_albumID, order_id: _orderID};
				$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': _token
		    }});

				$.ajax({
					type: "POST",
					url: "/submit/prints_purchase",
					data: data,
					success: function(){
            if(_orderID == ''){
              //after order has been submited
  						//redirect customer to page of order completion
  						window.location.replace("http://"+document.domain+"/user/dashboard");
            }
            else{
              location.reload();
            }

				}});
			}//end else
		});//end storageEngine.findAll
	});
})(pubsub,storageEngine);
