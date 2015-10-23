$(document).ready(function(){
	storageEngine.init(function(){
			storageEngine.initObjectStore("photo_prints",function(){
					storageEngine.clearAll("photo_prints",function(){
						var length = selections.length;
						var list = [];
						for(var j = 0; j < length; j++){
							list.push(	{id: j, 
										photo_id: selections[j].client_album_photo_id.toString(),
										format_id: selections[j].format_id.toString(),
										quantity: selections[j].quantity.toString()});
						}
						storageEngine.saveList("photo_prints",list,function(result){
							request_page(1);
	})})})});

	$("#myModal").click(function(){
		$('#myModal').foundation('reveal', 'close');
	});

	$("#submit_order").click(function(e){
		storageEngine.findAll("photo_prints",function(photos){
			if(photos.length ==0){
				alert("Cannot submit an order with no photos selected");
			}
			else{
				$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }});
				var data = {_token:token, photos:photos,orderID:orderID};
				$.ajax({
					type: "POST",
					url: "/submit/edit_prints_purchase",
					data: data,
					success: function(){
						//after order has been submited
						//redirect customer to page of order completion
						window.location.replace(DOMAINNAME+"user/dashboard/orders_history");
				}});
			}
		});
	});
});
