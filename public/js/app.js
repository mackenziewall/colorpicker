var app = angular.module("colorpicker", [])
	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	});
	app.controller('navigationController', ['$http',function($http) {
			this.fork = function (){ 
				alert('fork');
			};
			this.refresh = function (){ 
				alert('refresh');
			};
			this.lock = function (){ 
				$http({
				  method: 'POST',
				  url: '/ajax/lock'
				}).then(function successCallback(response) {
				    swatch.blocks = response.data.blocks;
				    swatch.id = response.data.id;
				    swatch.status = response.data.status;
				  }, function errorCallback(response) {
				  	//
				  });
			};
			this.sass = function (){ 
				alert('sass');
			};
			this.share = function (){ 
				alert('share');
			};
	}]);
	app.controller ('SwatchController', ['$http', '$scope', '$timeout', '$location', '$interval', function ($http, $scope, $timeout, $location, $interval ){
		var swatch = this;
		var status;
	  $scope.layoutDone = function() {
	      //This is where we attach listeners to the elements in the ng-repeat loop
	      $timeout(function() { $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, showInitial: true, showInput: true}); }, 0); // wait...
	  }

	  this.update = function(){
	  	var url = $location.absUrl().split("/hex/");
			if( url.length == 1 )
				window.location = '/create';
			else if( url.length > 1 && url[1].length )
				var requesthttp = 'ajax/fetch/' + url[1];

			$http({
			  method: 'GET',
			  url: requesthttp
			}).then(function successCallback(response) {
					if(swatch.status == undefined || swatch.status < response.data.status) {
				    swatch.status = response.data.status;
				    swatch.blocks = response.data.blocks;
				    swatch.id = response.data.id;
				  }
			  }, function errorCallback(response) {
			  	//
			  });
		};
		this.update();
		$interval(function(){
			swatch.update();
		},5000);
}]);
