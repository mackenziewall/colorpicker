var app = angular.module("colorpicker", [])
	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	});

	//app.controller ('SwatchController', ['$http', '$scope', '$timeout', '$location', function ($http, $scope, $timeout, $location, $locationProvider ){
	app.controller ('SwatchController', ['$http', '$scope', '$timeout', '$location', function ($http, $scope, $timeout, $location ){
	//$locationProvider.html5Mode(true);
	var swatch = this;
  $scope.layoutDone = function() {
      //This is where we attach listeners to the elements in the gn-repeat loop
      $timeout(function() { $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, showInitial: true, showInput: true}); }, 0); // wait...
  }
  	var url = $location.absUrl().split("/hex/");

		if( url.length == 1 )
			window.location = '/create';
		else if( url.length > 1 && url[1].length )
			var requesthttp = 'ajax/fetch/' + url[1];

		$http({
		  method: 'GET',
		  url: requesthttp
		}).then(function successCallback(response) {
		    swatch.blocks = response.data.blocks;
		    swatch.id = response.data.id;
		    swatch.status = response.data.status;
		  }, function errorCallback(response) {
		  	//
		  });
}]);
