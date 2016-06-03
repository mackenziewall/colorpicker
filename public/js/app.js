var app = angular.module("colorpicker", ['ngRoute','doowb.angular-pusher'])
	.directive('repeatDone', function() {
		return function(scope, element, attrs) {
			if (scope.$last) { // all are rendered
				scope.$eval(attrs.repeatDone);
			}
		}
	})
	.filter('hex', function() {
		// In the return function, we must pass in a single parameter which will be the data we will work on.
		// We have the ability to support multiple other parameters that can be passed into the filter optionally
		return function(input) {
		// Do filter work here
		if(!input)
			return input;
		var output = '';
		if(input.charAt(0) != '#')
			output += '#';
		output += input;
		return output;
		}
	})
	.factory('SwatchData', [function() {
		return {};
	}])
	.config(['$routeProvider', '$locationProvider', '$compileProvider', 'PusherServiceProvider',
		function($routeProvider, $locationProvider, $compileProvider, PusherServiceProvider) {
		PusherServiceProvider
			.setToken('c21f8f702f50baff6a10')
			.setOptions({});
		}
	])
	.controller('SwatchController', ['$http', '$scope', '$timeout', '$window', 'SwatchData', 'Pusher', 
	function ($http, $scope, $timeout, $window, SwatchData, Pusher ) {

		$scope.SwatchData = SwatchData;
		var self = this;
		var status;
		var url = $scope.SwatchData.url;
		var requesthttp = 'ajax/fetch/' + $scope.SwatchData.slug;

		$scope.layoutDone = function() { 
			//This is where we attach listeners to the elements in the ng-repeat loop
			if(!$scope.SwatchData.lock)
				$timeout(function() { $(".picker").spectrum({showSelectionPalette: true, clickoutFiresChange: true, preferredFormat: "hex", showInitial: true, showInput: true}); }, 0); // wait...
		}

		$scope.SwatchData.singleblock = function (){ 
			if(_.keys($scope.SwatchData.blocks).length > 1)
				return false;
			return true;
		};

		$scope.SwatchData.addblock = function (){ 
			var seed = Math.random();
			var color = seed.toString(16).slice(2, 8);
			var tempid = Math.random().toString(10).slice(2, 8);
console.log('line58');
			$scope.SwatchData.blocks[tempid] = {id: tempid, value: color};
			console.log('line60');
			$http({
					method: 'POST',
					url: 'ajax/add',
					data: { 'slug' : $scope.SwatchData.slug, 'value': color }
				}).then(function successCallback(response) {
					 $scope.SwatchData.blocks[tempid].id = response.data.id;
				}, function errorCallback(response) {$scope.SwatchData.blocks.pop(); console.log('Connection Lost.');});
		};

		$scope.SwatchData.deleteblock = function ( blockid ){ 
			$http({
				method: 'POST',
				url: 'ajax/delete',
				data: { 'slug' : $scope.SwatchData.slug, 'block': blockid }
			}).then(function successCallback(response) {
					$scope.SwatchData.status = response.data.status;
					delete $scope.SwatchData.blocks[blockid];
			}, function errorCallback(response) {});
		};
		$scope.SwatchData.changeblock = function ( blockid, value ){ 
			$http({
				method: 'POST',
				url: 'ajax/update',
				data: { 'slug' : $scope.SwatchData.slug, 'block': blockid, 'value': value }
			}).then(function successCallback(response) {
				$scope.SwatchData.update();
			}, function errorCallback(response) {console.log('Connection Lost.');});
		};
		$scope.SwatchData.update = function(){
			$http({
				method: 'GET',
				url: requesthttp
			}).then(function successCallback(response) {
					if($scope.SwatchData.status == undefined || $scope.SwatchData.status < response.data.status) {
						$scope.SwatchData.status = response.data.status;console.log(response.data.blocks);
						delete $scope.SwatchData.blocks;
						$scope.SwatchData.blocks = response.data.blocks;
						$scope.SwatchData.id = response.data.id;
						$scope.SwatchData.lock = response.data.lock;
					}
			}, function errorCallback(response) {});
		};
		$scope.SwatchData.update();
		$scope.$on('global_event', function (angularEvent, pusherEventData) {
			$scope.SwatchData.update();
		});

		var clipboard = new Clipboard('.clippy');
		clipboard.on('success', function(e) {});

		$scope.callbackNotifications = 0;
		$scope.callbackNotification = '';
		$scope.eventNotifications = 0;
		$scope.eventNotification = '';

		Pusher.subscribe('swatch_update_trigger_'+$scope.SwatchData.slug, 'update', function (item) {
			console.log('update received');
			$scope.SwatchData.update();
		});
		$scope.$on('$destroy', function () {
			Pusher.unsubscribe('swatch_update_trigger_'+$scope.SwatchData.slug);
		});
	}])
	.controller('navigationController', ['$http', '$location', '$scope', '$window', 'SwatchData', function( $http, $location, $scope, $window, SwatchData ) {
			$scope.SwatchData = SwatchData;
			var swatch = SwatchData;
			var navigation = this;
			var url_array = $location.absUrl().split("/hex/");

			if( url_array.length == 2 )
				navigation.slug = $scope.SwatchData.slug = url_array[1];

			navigation.url = $location.absUrl();
			$scope.SwatchData.url = navigation.url;

			this.clone = function (){ 
				$http({
					method: 'POST',
					url: '/ajax/clone',
					data: { 'slug' : navigation.slug }
				}).then(function successCallback(response) {
						if(response.data.slug && response.data.slug.length)
							$window.location.href = url_array[0] + "/hex/" + response.data.slug;
					}, function errorCallback(response) {});
			};

			this.lock = function (){ 
				$http({
					method: 'POST',
					url: '/ajax/lock',
					data: { 'slug' : navigation.slug }
				}).then(function successCallback(response) {
						$scope.SwatchData.locked = 1;
						navigation.locked = 1;
						$('.sp-replacer').hide();
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
			
			var clipboard = new Clipboard('.clippy');
			clipboard.on('success', function(e) {
				console.log('Copied to clipboard!');
				//$("#" + e.trigger.id).tooltip('Copied!');
				//e.trigger.tooltip('Copied!');
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
});

var prod = false;
//http://stackoverflow.com/questions/19519535/detect-if-browser-tab-is-active-or-user-has-switched-away
var vis = (function(){
	var stateKey, eventKey, keys = {
		hidden: "visibilitychange",
		webkitHidden: "webkitvisibilitychange",
		mozHidden: "mozvisibilitychange",
		msHidden: "msvisibilitychange"
	};
	for (stateKey in keys) {
		if (stateKey in document) {
			eventKey = keys[stateKey];
			break;
		}
	}
	return function(c) {
		if (c) document.addEventListener(eventKey, c);
		return !document[stateKey];
	}
})();