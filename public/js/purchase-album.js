
$(document).ready(function(){
	storageEngine.init(function(){
			storageEngine.initObjectStore("photos",function(){
				storageEngine.clearAll("photos",function(){							
					request_page(1);
		})})});

	$("#myModal").click(function(){
		$('#myModal').foundation('reveal', 'close');
	});
	$("#submit_order").click(function(e){
		storageEngine.findAll("photos",function(photos){
			if(photos.length ==0){
				alert("Cannot submit an order with no photos selected");
			}
			else{
				var data = {photos:photos,album_id:albumID};
				$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }});
				$.ajax({
					type: "POST",
					url: "/submit/album_purchase",
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
