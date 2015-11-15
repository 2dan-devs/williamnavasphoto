angular.module('wnp')
.factory('SharedServices', function($http) {
	var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
	// get photos for album
	function getAlbumPhotos(albumId) {
		return $http({
	                method: 'POST',
	                url: 'frontendapi/getPortfolioAlbumPhotos',
	                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
	                data: albumId
            	});
	}
	// get albums names
	function getAlbumNames() {
		return $http({
	                method: 'POST',
	                url: 'frontendapi/getAllPortfolioAlbums',
	                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            	});
	}
	// get contact info
	function getContactInfo() {
		return $http({
	                method: 'POST',
	                url: 'frontendapi/getContact',
	                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            	});
	}
	// get about info
	function getAboutInfo() {
		return $http({
	                method: 'POST',
	                url: 'frontendapi/getAbout',
	                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            	});
	}
	// post contact form to backend
	function submitForm(formData) {
		var dataSet = {
			name: formData.name,
			phone: formData.phone,
			email: formData.email,
			message: formData.message,
			contactMethod: formData.contactMethod,
			morning: formData.morning,
			afternoon: formData.afternoon,
			night: formData.night
		}
		return $http({
						method: 'POST',
						url: 'frontendapi/post_message',
						headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
						data: dataSet
					});
	}

	return {
		getAlbumPhotos: getAlbumPhotos,
		 getAlbumNames: getAlbumNames,
		getContactInfo: getContactInfo,
		  getAboutInfo: getAboutInfo,
		  submitForm: submitForm
	};
});