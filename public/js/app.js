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
	.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.timeout = 5000;
	}])
	.controller('SwatchController', ['$http', '$scope', '$timeout', '$window', 'SwatchData', 'Pusher', 'CSRF_TOKEN', 
	function ($http, $scope, $timeout, $window, SwatchData, Pusher, CSRF_TOKEN ) {
		$scope.SwatchData = SwatchData;
		$scope.SwatchData.anchored = [];
		var self = this;
		var status;
		self.url = $scope.SwatchData.url;
		var requesthttp = 'ajax/fetch/' + $scope.SwatchData.slug;

		$scope.layoutDone = function() { 
			//This is where we attach listeners to the elements in the ng-repeat loop
			if(!$scope.SwatchData.locked)
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
			var tempid = seed.toString(10).slice(2, 8);

			$scope.SwatchData.blocks[tempid] = {id: tempid, value: color};

			$http({
					method: 'POST',
					url: 'ajax/add',
					data: { 'slug' : $scope.SwatchData.slug, 'value': color }
				}).then(function successCallback(response) {
					 $scope.SwatchData.blocks[tempid].id = response.data.id;
				}, function errorCallback(response) {console.log('Connection Lost.');});
		};

		$scope.SwatchData.deleteblock = function ( blockid ){ 
			$http({
				method: 'POST',
				url: 'ajax/delete',
				data: { 'slug' : $scope.SwatchData.slug, 'block': blockid, csrf_token: CSRF_TOKEN }
			}).then(function successCallback(response) {
					$scope.SwatchData.status = response.data.status;
					delete $scope.SwatchData.blocks[blockid];
			}, function errorCallback(response) {});
		};

		$scope.SwatchData.clone = function (){
			$http({
				method: 'POST',
				url: '/ajax/clone',
				data: { 'slug' : $scope.SwatchData.slug, csrf_token: CSRF_TOKEN }
			}).then(function successCallback(response) {
					if(response.data.slug && response.data.slug.length)
						$window.location.href = "/hex/" + response.data.slug;
				}, function errorCallback(response) {});
		};

		$scope.SwatchData.changeblock = function ( blockid, value ){ 
			$http({
				method: 'POST',
				url: 'ajax/update',
				data: { 'slug' : $scope.SwatchData.slug, 'block': blockid, 'value': value, csrf_token: CSRF_TOKEN }
			}).then(function successCallback(response) {
				// $scope.SwatchData.update();
			}, function errorCallback(response) {console.log('Connection Lost.');});
		};
		$scope.SwatchData.update = function(){
			$http({
				method: 'GET',
				url: requesthttp
			}).then(function successCallback(response) {
					if($scope.SwatchData.status == undefined || $scope.SwatchData.status < response.data.status) {
						console.log('updating...');
						$scope.SwatchData.status = response.data.status;
						var blockarray = jQuery.makeArray(response.data.blocks);
						$scope.SwatchData.blocks = blockarray;
						$scope.SwatchData.blocks = response.data.blocks;
						$scope.SwatchData.id = response.data.id;
						$scope.SwatchData.locked = response.data.lock;

						if($scope.SwatchData.anchored == undefined)
							$scope.SwatchData.anchored = [];
						$scope.SwatchData.blocks.forEach(function (block) {
							if($scope.SwatchData.anchored[block.id] == undefined)
								$scope.SwatchData.anchored[block.id] = false;
						});
					}
			}, function errorCallback(response) {});
		};
						
		$scope.SwatchData.update();
		$scope.$on('global_event', function (angularEvent, pusherEventData) {
			$scope.SwatchData.update();
		});

		$scope.callbackNotifications = 0;
		$scope.callbackNotification = '';
		$scope.eventNotifications = 0;
		$scope.eventNotification = '';

		$scope.SwatchData.generatesass = function (){
			$http({
				method: 'GET',
				url: 'ajax/sass/' + $scope.SwatchData.slug
			}).then(function successCallback(response) {
				$scope.SwatchData.sass = response.data.sass;
				}, function errorCallback(response) {});
		};

		$scope.SwatchData.anchor = function (id){
			if ($scope.SwatchData.anchored[id] != true)
			{
				$scope.SwatchData.anchored[id] = true;
			}
			else
			{
				$scope.SwatchData.anchored[id] = false;
			}
		};

		var clipboard = new Clipboard('.clippy');
		clipboard.on('success', function(e) {
			if(e.trigger.type == 'text')
			{
				var contentcopied = $("#" + e.trigger.id).val();
				setTimeout( function() { $("#" + e.trigger.id).val('Copied!'); }, 100);
				setTimeout( function() { $("#" + e.trigger.id).val(contentcopied); }, 1500);
			}
			else if(e.trigger.type == 'button')
			{
				var contentcopied = $("#" + e.trigger.id).html();
				setTimeout( function() { $("#" + e.trigger.id).html('Copied!'); }, 100);
				setTimeout( function() { $("#" + e.trigger.id).html(contentcopied); }, 1500);
			}
		});

		Pusher.subscribe('swatch_update_trigger_'+$scope.SwatchData.slug, 'update', function (item) {
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
			this.scramble = function (){ 
				var scramblevalues = [];
				//$scope.SwatchData.blocks.forEach(function(data){
				Object.keys($scope.SwatchData.blocks).forEach(function (key) {
					if ($scope.SwatchData.anchored[$scope.SwatchData.blocks[key].id] != true)
					{
						scramblevalues.push({key:key,id: $scope.SwatchData.blocks[key].id, value:Math.random().toString(16).slice(2, 8)});
					}
				});
				var i = 0, l = scramblevalues.length;
				(function iterator() {
							$scope.SwatchData.blocks[scramblevalues[i].key].value = scramblevalues[i].value;
							$scope.SwatchData.changeblock(scramblevalues[i].id, scramblevalues[i].value); 
				    if(++i<l) {
				        setTimeout(iterator, 500);
				    }
				})();
				// $scope.SwatchData.blocks;
			};
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

function cleanArray(actual) {
  var newArray = new Array();
  for (var i = 0; i < actual.length; i++) {
    if (actual[i]) {
      newArray.push(actual[i]);
    }
  }
  return newArray;
}