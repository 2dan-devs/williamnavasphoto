angular.module('wnp')
.controller('HomeCtrl', function($scope, SharedServices, $rootScope) {
	// Get albums names to populate sidebar gallery menu.
	SharedServices.getAlbumNames()
	.success(function(data) { // data: response from server.
		$scope.albums = data;
	});
	// This is used to set active color highlight on sidebar links.
	$scope.toggleObject = {item: -1};
});
