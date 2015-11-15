var printsGallery = (function(pubsub){
  "use strict";

  var that = gallery(pubsub);

  pubsub.subscribe("checkedOrder", _addPhoto);

  var photoFormats = [];

  //Get all photo formats
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('#csrf-token').attr('value')
  }});
  $.ajax({
    type: "POST",
    url: "/frontendapi/getAllFormats",
    async: false,
    success: function(results){
      photoFormats = results;
  }});


  /**
		Click event lower the photo quantity by one
	*/
	function _clickDownButtonEvent(e){
		var $qtyInputField = $(e.target).parent().next().find("input");
		var picQtyString = $qtyInputField.val();
		if(picQtyString == '')
			$qtyInputField.val('1');
		else
		{
			var picQty = parseInt(picQtyString);
			if(picQty>1) picQty--;
			$qtyInputField.val(picQty);
		}
	}

	/**
		Click event raise the photo quantity by one
	*/
	function _clickUpButtonEvent(e){
		var $qtyInputField = $(e.target).parent().prev().find("input");
		var picQtyString = $qtyInputField.val();
		if(picQtyString == '')
			$qtyInputField.val('1');
		else
		{
			var picQty = parseInt(picQtyString);
			picQty++;
			$qtyInputField.val(picQty);
		}
	}

  function _clickDeleteButtonEvent(e){
		var $rowDiv = $(e.target).parent().parent();
		var $pictureDiv = $rowDiv.parent();
		var $deleteSelect = $rowDiv.find("select");
		var $addSelect = $pictureDiv.children().last().find("select");

		var photoID = $pictureDiv.attr('id');
		var formatID = parseInt($deleteSelect.val());
		var formatText = $deleteSelect.text();

    $rowDiv.remove();
    $addSelect.append('<option value="'+formatID+'">'+formatText+'</option>');

    pubsub.publish("clickDeleteButtonEvent",{photoID : photoID, formatID : formatID});
	}//end clickDeleteButtonEvent

  function _clickAddButtonEvent(e){
		var $addButton = $(e.target);
		var $rowDiv = $addButton.parent().parent();
		var $pictureDiv = $rowDiv.parent();
		var $qtyInput = $rowDiv.find("input");
		var $formatSelect = $rowDiv.find("select");

		var htmloutput = '';
		var photoID = $pictureDiv.attr('id');
		var formatID = $formatSelect.val();
		var qty = $qtyInput.val();
		var $newRow = {};
		var $deleteButton = {};

		if(formatID ==-1)
			alert("Select photo format before adding");
		else if(qty===''  || parseInt(qty) < 1)
			alert("Must have a quantity greater then 0");
		else{
      $qtyInput.val(1);
      $formatSelect.find('option:selected').remove();

      htmloutput +=	'<div class="row">';
      htmloutput +=		'<div class="medium-5 large-5 columns">';
      htmloutput += 				'<select class="pictureFormat" disabled="disabled">';
      htmloutput +=					'<option value="'+formatID+'" selected="selected">'+photoFormats[formatID - 1].format+'</option>';
      htmloutput +=				'</select>';
      htmloutput +=		'</div>';
      htmloutput +=		'<div class="medium-2 large-2 columns large-offset-1 picture-quantity-container">';
      htmloutput +=			'<input type="text" class="picture-quantity" disabled="disabled" value="'+qty+'">';
      htmloutput +=		'</div>';
      htmloutput +=		'<div class="medium-2 large-2 columns delete-container large-offset-1">';
      htmloutput += 			'<i class="fa fa-times fa-2x delete-button"></i>';
      htmloutput +=		'</div>';
      htmloutput +=	'</div>';
      $(htmloutput).insertBefore($rowDiv);
      $newRow = $rowDiv.prev();
      $deleteButton = $newRow.find("i");
      $deleteButton.on("click", _clickDeleteButtonEvent);

      pubsub.publish("clickAddButtonEvent",{photo_id : photoID, format_id : formatID, quantity : qty})
		}//end else
	}//end clickAddButtonEvent

  /**
    Checks that the quantity input are only numbers
  */
  function _isNumber(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
          return false;
      }
      return true;
  }

  function _addPhoto(photo){
			var deleteButtons ={};
			var htmloutput = "";
			var flag = true;
			var resultsLength = photo.results.length;
			var formatsLength = photoFormats.length;
			var currentRow = {};

			//adds a new row to page for every fourth photo
			if(photo.index%4==1) {
				htmloutput+='<div class="row"></div>';
				that._resultsBox.insertAdjacentHTML("beforeend", htmloutput);
				htmloutput="";
			}
      currentRow = that._resultsBox.lastChild;

			//Create htmloutput to be added to page
			htmloutput += 	'<div id="'+photo.id+'" class="photo-container medium-3 large-3 columns end">';
			htmloutput += 		'<span data-reveal-id="myModal"></span>'
			htmloutput +=		'<img src="/'+ photo.photo_path_low_res +'" />';

			//add selected formats and quatities with delete button
			for(var i = 0;i < resultsLength; i++){
				htmloutput +=	'<div class="row">';
				htmloutput +=		'<div class="medium-5 large-5 columns">';
				htmloutput += 				'<select class="picture-format" disabled="disabled">';
				htmloutput +=					'<option value="'+photoFormats[photo.results[i].format_id - 1].id+'" selected="selected">'+photoFormats[photo.results[i].format_id - 1].format+'</option>';
				htmloutput +=				'</select>';
				htmloutput +=		'</div>';
				htmloutput +=		'<div class="medium-2 large-2 columns picture-quantity-container large-offset-1">';
				htmloutput +=			'<input type="text" class="picture-quantity" disabled="disabled" value="'+photo.results[i].quantity+'">';
				htmloutput +=		'</div>';
				htmloutput +=		'<div class="medium-2 large-2 columns delete-container large-offset-1">';
				htmloutput += 			'<i class="fa fa-times fa-2x delete-button"></i>';
				htmloutput +=		'</div>';
				htmloutput +=	'</div>';
			}
			htmloutput +=		'<div class="row">';
			htmloutput +=			'<div class="medium-5 large-5 columns">';
			htmloutput += 				'<select class="picture-format">';
			htmloutput +=					'<option value="-1" selected="selected"></option>';

      //adds selection options that client has not already used
      for(var i = 0; i < formatsLength; i++){
        for(var j = 0; j < resultsLength  && flag; j++)
          if(photoFormats[i].id == photo.results[j].format_id)
            flag = false;
          if(flag)
            htmloutput +=			'<option value="'+photoFormats[i].id+'">'+photoFormats[i].format+'</option>';
        flag = true;
      }

			htmloutput +=				'</select>';
			htmloutput +=			'</div>';
			htmloutput +=			'<div class="medium-1 large-1 columns arrow-container">';
			htmloutput += 				'<i class="fa fa-caret-down fa-2x down-arrow"></i>';
			htmloutput +=			'</div>';
			htmloutput +=			'<div class="medium-2 large-2 columns picture-quantity-container">';
			htmloutput +=				'<input type="text" class="picture-quantity" onkeypress="return printsGallery.isNumber(event)" onkeypress="return printsGallery.isNumber(event)" value="1">';
			htmloutput +=			'</div>';
			htmloutput +=			'<div class="medium-1 large-1 columns arrow-container">';
			htmloutput += 				'<i class="fa fa-caret-up fa-2x up-arrow"></i>';
			htmloutput +=			'</div>';
			htmloutput +=			'<div class="medium-1 large-2 columns add-container">';
			htmloutput += 				'<i class="fa fa-plus fa-2x add-button">';
			htmloutput +=			'</div>';
			htmloutput +=		'</div>';//end div row
			htmloutput += 	'</div>';//end photo div

			//add htmloutput to page
			currentRow.insertAdjacentHTML("beforeend", htmloutput);

			//add Events to all buttons
			currentRow.lastChild.firstChild.addEventListener("click",that._zoomInEvent);
			currentRow.lastChild.lastChild.children[1].firstChild.addEventListener("click", _clickDownButtonEvent);
			currentRow.lastChild.lastChild.children[3].firstChild.addEventListener("click", _clickUpButtonEvent);
			currentRow.lastChild.lastChild.children[4].firstChild.addEventListener("click", _clickAddButtonEvent);
			deleteButtons = currentRow.lastChild.getElementsByClassName("delete-button");
			for(var i = 0; i < deleteButtons.length;i++)
				deleteButtons[i].addEventListener("click",_clickDeleteButtonEvent);
	}//end addPhoto function
})(pubsub);
