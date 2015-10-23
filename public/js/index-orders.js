
$(document).ready(function(){

	$("select").change(function(e){
		var $select = $(e.target);
		var orderID = $select.attr('id');
		var status = $select.val();
		var data = {status:status,orderID:orderID};
		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
		$.ajax({
			type: "POST",
			url: "/admin/dashboard/orders/update_status",
			data: data,
			success: function(){}
		});
	});
});