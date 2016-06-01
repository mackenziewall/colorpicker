var app = angular.module("colorpicker", [])
	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	});
	app.filter('hex', function() {
	  // In the return function, we must pass in a single parameter which will be the data we will work on.
	  // We have the ability to support multiple other parameters that can be passed into the filter optionally
	  return function(input) {
	    // Do filter work here
	    var output = '';
	    if(input.charAt(0) != '#')
	    	output += '#';
	    output += input;
	    return output;
	  }
	});
	app.controller ('SwatchController', ['$http', '$scope', '$timeout', '$location', '$interval', function ($http, $scope, $timeout, $location, $interval ){
		var swatch = this;
		var status;
  	var url = $location.absUrl().split("/hex/");
		if( url.length == 1 )
			window.location = '/create';
		else if( url.length > 1 && url[1].length ){
			var requesthttp = 'ajax/fetch/' + url[1];
			swatch.slug = url[1];
		}
	  $scope.layoutDone = function() { 
	      //This is where we attach listeners to the elements in the ng-repeat loop
	      if(!swatch.lock)
	      	$timeout(function() { $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, preferredFormat: "hex", showInitial: true, showInput: true}); }, 0); // wait...
	  }
		this.singleblock = function (){ 
			if(_.keys(swatch.blocks).length > 1)
				return false;
			return true;
		};
		this.addblock = function (){ 
			$http({
			  method: 'GET',
			  url: 'ajax/add/'+ swatch.slug
			}).then(function successCallback(response) {
				    swatch.status = response.data.status;
				    swatch.blocks = response.data.blocks;
			  }, function errorCallback(response) {});
		};
		this.deleteblock = function ( blockid ){ 
			$http({
			  method: 'POST',
			  url: 'ajax/delete',
        data: { 'slug' : swatch.slug, 'block': blockid }
			}).then(function successCallback(response) {
				    swatch.status = response.data.status;
						delete swatch.blocks[blockid];
			  }, function errorCallback(response) {});
		};
		this.changeblock = function ( blockid, value ){ 
			$http({
			  method: 'POST',
			  url: 'ajax/update',
        data: { 'slug' : swatch.slug, 'block': blockid, 'value': value }
			}).then(function successCallback(response) {
					swatch.update();
			  }, function errorCallback(response) {});
		};
	  this.update = function(){
			$http({
			  method: 'GET',
			  url: requesthttp
			}).then(function successCallback(response) {
					if(swatch.status == undefined || swatch.status < response.data.status) {
				    swatch.status = response.data.status;
				    swatch.blocks = response.data.blocks;
				    swatch.id = response.data.id;
				    swatch.lock = response.data.lock;
				  }
			  }, function errorCallback(response) {});
		};
		this.update();
		var clipboard = new Clipboard('.clippy');
		clipboard.on('success', function(e) {});
		// $interval(function(){
		// 	swatch.update();
		// },5000);
}]);

	app.controller('navigationController', ['$http', '$location', function( $http, $location ) {
			var navigation = this;
	  	var url_array = $location.absUrl().split("/hex/");
			if( url_array.length == 2 )
				navigation.slug = url_array[1];
			navigation.url = $location.absUrl();

			this.fork = function (){ 
				alert('fork');
			};
			this.refresh = function (){ 
				alert('refresh');
			};
			this.lock = function (){ 
				$http({
				  method: 'POST',
				  url: '/ajax/lock',
        	data: { 'slug' : navigation.slug }
				}).then(function successCallback(response) {
						//
				  }, function errorCallback(response) {});
			};
			this.sass = function (){ 
				$http({
				  method: 'GET',
				  url: 'ajax/sass/' + navigation.slug
				}).then(function successCallback(response) {
				    navigation.sass = response.data.sass;
				  }, function errorCallback(response) {});

				navigation.url = $location.absUrl();
			};
			this.sass();
			this.share = function (){ 
				alert(url);
			};
			var clipboard = new Clipboard('.clippy');
			clipboard.on('success', function(e) {
			  
			});
	}]);

	app.service('swatchService', function() {
  var swatch;

  var addSwatch = function(newObj) {
      swatch = newObj;
  };

  var getSwatch = function(){
      return swatch;
  };

  return {
    addProduct: addProduct,
    getProducts: getProducts
  };

});
