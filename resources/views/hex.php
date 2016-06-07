<!DOCTYPE html>
<html lang="en">
		<head>
				<title>HueHueHue</title>
				<base href="/home.php" />
				<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
				<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
				<script src="https://code.angularjs.org/1.4.8/angular-route.js"></script>
				<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
				<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
				<link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
				<script type="text/javascript" src="/js/bootstrap.min.js"></script>
				<link rel="stylesheet" href="/css/font-awesome.min.css">
				<script type="text/javascript" src="/js/underscore-min.js"></script>
				<script type="text/javascript" src="/js/spectrum.js"></script>
				<link rel="stylesheet" type="text/css" href="/css/spectrum.css">
				<script type="text/javascript" src="/js/clipboard.min.js"></script>
				<script type="text/javascript" src="/js/doowb.angular-pusher.js"></script>
				<script src="https://js.pusher.com/3.1/pusher.min.js"></script>
				<script type="text/javascript" src="/js/app.js"></script>
				<link rel="stylesheet" type="text/css" href="/css/app.css">
				<script>
				  angular.module("colorpicker").constant("CSRF_TOKEN", '<?php echo csrf_token(); ?>');
				</script>
				<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
				<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
				<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
				<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
				<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
				<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
				<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
				<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
				<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
				<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
				<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
				<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
				<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
				<meta name="msapplication-TileColor" content="#ffffff">
				<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
				<meta name="theme-color" content="#ffffff">
		</head>
		<body role="document" ng-app="colorpicker">
				<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner" ng-controller="navigationController as navigation">
				  <div class="container">
				    <div class="navbar-header">
				      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a href="./" class="navbar-brand"></a>
				    </div>
				    <nav class="navbar-collapse bs-navbar-collapse collapse" role="navigation" style="height: 1px;">
				      <ul class="nav navbar-nav">
								<li><a href="/create"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="nav-label">New</span></a></li>
								<li><a type='button' ng-hide="SwatchData.locked" title="This will pick new random colors on any non-anchored block!" ng-click="navigation.scramble()"><i class="fa fa-random" aria-hidden="true"></i> <span class="nav-label">Scramble</span></a></li>
								<li><a type='button' ng-hide="SwatchData.locked" ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
				      </ul>
				    </nav>
				  </div>
				</header>
				<div ng-controller="SwatchController as swatch" class="cbody">
					<div class="container theme-showcase content-row content-row-1">
						<div class="swatch" ng-show="SwatchData.blocks" ng-cloak>
								<div class="startblock block"></div>
								<div class="blockbucket">
										<span ng-repeat="block in SwatchData.blocks" repeat-done="layoutDone()">
												<div ng-hide="block.value == ''" class="colorblock block" id="block{{block.id}}" style="background-color:{{block.value | hex}};">
														<span class="color-input">
																<input ng-hide="SwatchData.locked" type="text" ng-model="block.value" ng-change="SwatchData.changeblock(block.id,block.value)" class="picker" name="picker-{{block.id}}" value="{{block.value | hex}}" /> 
																<input type="text" onClick="this.select();" class="blabel clippy pointer" title="copy to clipboard" onClick="this.select();" data-clipboard-target="#clip-b{{block.id}}" id="clip-b{{block.id}}" name="value-{{block.id}}" value="{{block.value | hex}}" readonly/> 
														</span>
														<button ng-hide="SwatchData.locked" ng-class="{ anchored: SwatchData.anchored[block.id] == true }" ng-click="SwatchData.anchor(block.id)" id="scrambler-t{{block.id}}" type="button" class="btn scramble-toggle blabel" data-toggle="button"><i class="fa fa-anchor" aria-hidden="true"></i></button>
														<a ng-hide="SwatchData.locked || SwatchData.singleblock()" ng-click="SwatchData.deleteblock(block.id)" class="delete pointer"><i class="fa fa-times" aria-hidden="true"></i></a>
												</div>
										</span>
								</div>
								<div class="endblock block"><a type='button' ng-hide="SwatchData.locked" ng-click="SwatchData.addblock()" class="addnew pointer"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
						</div>
					</div>
					<div class="theme-showcase content-row content-row-2">
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<h2>Share</h2>
										<input id="clip-share" value="{{SwatchData.url}}" value="{{SwatchData.url}}" class="clipboard clipboard-text"><button id="clip-share-btn" type='button' class="clippy btn bclipboard generic" title="copy url to clipboard" data-clipboard-target="#clip-share">Copy</button>
									<hr/>
									<h2>Clone</h2>
									<p><button class="btn generic" ng-click="SwatchData.clone()" >Click here</button> uplicate this set of colors to a new color swatch. </p>
							 	</div>
								<div class="col-md-6">
									<h2>Sass</h2>
									<p><button class="btn generic" href="#nogo" ng-click="SwatchData.generatesass()" >Generate Sass</button> and paste your variables directly into your project. </p><br/>
									<div ng-show="SwatchData.sass"><textarea id="clip-sass" ng-model="SwatchData.sass" class="clipboard clipboard-textarea" >{{SwatchData.sass}}</textarea><button id="clip-sass-btn" type='button' class="clippy btn generic clipboard" title="copy url to clipboard" data-clipboard-target="#clip-sass">Copy</button></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="theme-showcase content-row content-row-3">
					<div class="container">
							<!--<div class="row">
							<div class="col-md-12">
								<h2>Blog</h2>
								<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
							</div>
						</div>
						<hr>-->
						<footer>
							<p>© Copyright <?php echo date("Y"); ?></p>
						</footer>
					</div>
				</div>
		</body>
</html>
