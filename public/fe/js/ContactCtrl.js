angular.module('wnp')
.controller('ContactCtrl', function($scope, SharedServices) {
   $scope.formData = {};
   var wnpform = angular.element('#wnpform');

   // form input values
   $scope.formData.name;
   $scope.formData.phone;
   $scope.formData.message;
   $scope.formData.email;

   // Value comes from radio buttons
   $scope.formData.contactMethod = 'phone';

   // values from check boxes
   $scope.formData.morning = 'no';
   $scope.formData.afternoon = 'no';
   $scope.formData.night = 'no';

   $scope.submitForm = function() {
      SharedServices.submitForm($scope.formData)
      .success(function(data, status, headers, config) {
         // inform user that message was received
         wnpform.html('<div class="thankyou">' +
                        '<p>Thank you for your message!</p>' +
                        '<p>We will contact you soon.</p>' +
                      '</div>');
      });
   }
});
