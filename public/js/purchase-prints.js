
$(document).ready(function(){
	storageEngine.init(function(){
			storageEngine.initObjectStore("photo_prints",function(){
				storageEngine.clearAll("photo_prints",function(){		
					request_page(1);
		})})});

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
				var data = {photos:photos,album_id:albumID};
				$.ajax({
					type: "POST",
					url: "/submit/prints_purchase",
					data: data,
					success: function(){
						//after order has been submited
						//redirect customer to page of order completion
						window.location.replace(DOMAINNAME+"user/dashboard");
				}});
			}
		});
	});
});
