// Main module declaration and assignment.
var wnp = angular.module('wnp', ['ngRoute', 'ngSanitize', 'ngAnimate', 'ngTouch'])
.run(function() {
	FastClick.attach(document.body);
});
