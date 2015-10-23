angular.module('wnp')
.directive('dnImageZoom', function($compile) {
	return {
		restrict: 'A',
		replace: false,
		transclude: false,
		scope: false,
		template: '',
		link: function(scope, elem, attrs) {
			// Load clicked image into frame.
			elem.bind('click', function() {
				scope.$parent.index = parseInt(attrs.index);

				// append frame and append image into frame
				scope.cont.append(scope.frame);
				scope.frame.hide();
				scope.frame.append(
					$compile('<img src=" '+ scope.albumPhotos[attrs.index].photo_path +
					' " alt="portfolio photo" ng-swipe-left="nextSlide()" ng-swipe-right="prevSlide()">')(scope)
				);
				// Fade in animations.
				scope.frame.fadeIn();
				scope.leftNav.fadeIn();
				scope.rightNav.fadeIn();
	    	});

			// When clicking frame, exit slideshow.
			scope.frame.bind('click', function() {
				scope.leftNav.fadeOut(400);
				scope.rightNav.fadeOut(400);
				scope.frame.fadeOut(400, function() {
					scope.frame.html('');
				});
			});
		}
	};
});
