angular.module('wnp')
.controller('AboutCtrl', function($scope, SharedServices) {

   // Get data for about template from backend api.
   SharedServices.getAboutInfo()
   .success(function(data) {
      $scope.aboutData = data;
   });

   // Get contact info from backend api.
   SharedServices.getContactInfo()
   .success(function(data) {
      $scope.contactData = data;
   });

});
