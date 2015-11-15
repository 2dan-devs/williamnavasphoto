angular.module('wnp').controller('GalleryCtrl', function($scope, SharedServices, $routeParams, $compile) {
	// Get id from route using pagename property of $routeParams.
	var id = parseInt($routeParams.galleryID);

	// If route name is not present, we are at home, load first gallery as home.
	if ($routeParams.galleryID === undefined) id = 1;

	// Request gallery with "id" from SharedServices.
	SharedServices.getAlbumPhotos({"id": id})
	.success(function(data) { // data: response from server.
		$scope.albumPhotos = data;
	});

	// /////////////////////// SLIDER CONTROLS /////////////////////// //
	$scope.cont  = angular.element('#wrapper');
	$scope.frame = angular.element(
		$compile('<div id="frame"></div>')($scope)
	);
	$scope.leftNav  = angular.element('.slideshow-nav-left');
	$scope.rightNav = angular.element('.slideshow-nav-right');
	$scope.leftNav.hide();
	$scope.rightNav.hide();

	// portfolio photo index. Comes from Directive when photo is clicked.
	$scope.index;

	// Function to execute when left nav button is clicked.
	$scope.prevSlide = function() {
		$scope.frame.html(''); // clear frame
		if ($scope.index === 0) {
			$scope.index = $scope.albumPhotos.length-1;
		} else {
			$scope.index--;
		}
		$scope.elem = angular.element(
			$compile('<img src=" '+ $scope.albumPhotos[$scope.index].photo_path +
			' " alt="photo" ng-swipe-left="nextSlide()" ng-swipe-right="prevSlide()">')($scope)
		);
		$scope.frame.append($scope.elem.hide().fadeIn('slow'));
	};

	// Function to execute when right nav button is clicked.
	$scope.nextSlide = function() {
		$scope.frame.html(''); // clear frame
		if ($scope.index === $scope.albumPhotos.length-1) {
			$scope.index = 0;
		} else {
			$scope.index++;
		}
		$scope.elem = angular.element(
			$compile('<img src=" '+ $scope.albumPhotos[$scope.index].photo_path +
			' " alt="photo" ng-swipe-left="nextSlide()" ng-swipe-right="prevSlide()">')($scope)
		);
		$scope.frame.append($scope.elem.hide().fadeIn('slow'));
	};
	// ////////////////////// END SLIDER CONTROLS /////////////////// //
});
