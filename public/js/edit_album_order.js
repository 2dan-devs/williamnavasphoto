$(document).ready(function(){

	storageEngine.init(function(){
			storageEngine.initObjectStore("photos",function(){
				storageEngine.clearAll("photos",function(){
					var length = selectedPhotos.length;
					var list = [];
					for(var j = 0; j < length; j++){
						list.push({id: j.toString(), photo_id: selectedPhotos[j].client_album_photo_id.toString()});
					}
					storageEngine.saveList("photos",list,function(result){
						request_page(1);
	})})})});

	$("#myModal").click(function(){
		$('#myModal').foundation('reveal', 'close');
	});
	$("#submit_order").click(function(e){
		storageEngine.findAll("photos",function(photos){
			if(photos.length ==0){
				alert("Cannot submit an order with no photos selected");
			}
			else{
				var data = {_token:token, photos:photos,orderID:orderID};
				$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }});
				$.ajax({
					type: "POST",
					url: "/submit/edit_album_purchase",
					data: data,
					success: function(){
						location.reload();
				}});
			}
		});
	});
});
