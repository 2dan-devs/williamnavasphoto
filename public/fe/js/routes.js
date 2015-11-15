// routes
angular.module('wnp')
.config(function($routeProvider) {
	$routeProvider
	.when('/', {
    	templateUrl: '/fe/partials/_gallery.html',
    	controller: 'GalleryCtrl',
		disableCache: true
  	})
	.when('/about', {
    	templateUrl: '/fe/partials/_about.html',
    	controller: 'AboutCtrl'
  	})
	.when('/contact', {
		templateUrl: '/fe/partials/_contact.html',
		controller: 'ContactCtrl'
	})
	.when('/gallery/:galleryID', {
		// To call templates based on route parameters used below approach.
		// function(params) {return 'fe/partials/' + params.pagename + '.html'}
    	templateUrl: '/fe/partials/_gallery.html',
    	controller: 'GalleryCtrl',
		disableCache: true
  	})
	.otherwise({
		redirectTo: '/'
	});;
});
