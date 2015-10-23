$(document).ready(function(){

	// Remove session mesasge alert box.
	$(document).on('click', '#session-message-alert', function() {
    	$(this).parent().remove()
	})
})