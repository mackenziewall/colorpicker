var app = angular.module("colorpicker", [])

	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	})
	.controller ('SwatchController', function ($scope, $timeout){
	this.blocks = data.blocks;
  $scope.layoutDone = function() {
      //$('a[data-toggle="tooltip"]').tooltip(); // NOT CORRECT!
      $timeout(function() { $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, showInitial: true, showInput: true}); }, 0); // wait...
  }
});

var data = {"blocks":[{"id":1954,"value":"40c0a3"},{"id":1955,"value":"e981d6"},{"id":1956,"value":"ded1c3"},{"id":1954,"value":"40c0a3"},{"id":1955,"value":"e981d6"},{"id":1956,"value":"ded1c3"}],"status":1951,"id":"Oc"};
// $http({
//   method: 'GET',
//   url: '/hex/create'
// }).then(function successCallback(response) {
//     // this callback will be called asynchronously
//     // when the response is available
//     var data = response;
//   }, function errorCallback(response) {
//     // called asynchronously if an error occurs
//     // or server returns response with an error status.
//   });


// $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {alert(123);
//     $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, showInitial: true, showInput: true});
// });

// $(document).on("click", ".color-input", function(){

// $(document).find(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, showInitial: true, showInput: true});
// });
