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

		</head>
		<body role="document" ng-app="colorpicker">
				<!-- Fixed navbar -->
<!-- 				<div id="navbar" class="navbar-collapse collapse" aria-expanded="false">
            <ul class="nav navbar-nav">
            	<li><a href="/create"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="nav-label">New</span></a></li>
							<li><a type='button' ng-click="navigation.clone()"><i class="fa fa-clone" aria-hidden="true"></i> <span class="nav-label">Clone</span></a></li>
							<li><a type='button' ng-hide="navigation.locked" ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
            </ul>
          </div> -->
<!-- 				<nav id="navbar" class="navbar " aria-expanded="false">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="true" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="#">HueHueHue</a>
						</div>
						<div id="navbar" class="navbar-collapse collapse" aria-expanded="true" ng-controller="navigationController as navigation">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="/create"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="nav-label">New</span></a></li>
								<li><a type='button' ng-click="navigation.clone()"><i class="fa fa-clone" aria-hidden="true"></i> <span class="nav-label">Clone</span></a></li>
								<li><a type='button' ng-hide="navigation.locked" ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
							</ul>
						</div>
					</div>
				</nav> -->
				<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
				  <div class="container">
				    <div class="navbar-header" ng-controller="navigationController as navigation">
				      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a href="./" class="navbar-brand">HueHueHue</a>
				    </div>
				    <nav class="navbar-collapse bs-navbar-collapse collapse" role="navigation" style="height: 1px;">
				      <ul class="nav navbar-nav">
								<li><a href="/create"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="nav-label">New</span></a></li>
								<li><a type='button' ng-click="navigation.clone()"><i class="fa fa-clone" aria-hidden="true"></i> <span class="nav-label">Clone</span></a></li>
								<li><a type='button' ng-hide="navigation.locked" ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
				      </ul>
				    </nav>
				  </div>
				</header>


				<div ng-controller="SwatchController as swatch" class="cbody">
					<div class="container theme-showcase content-row content-row-1">
						<div class="swatch" ng-show="SwatchData.blocks" >
								<div class="startblock block"></div>
								<div class="blockbucket">
										<span ng-repeat="block in SwatchData.blocks" repeat-done="layoutDone()">
												<div ng-hide="block.value == ''" class="colorblock block" id="block{{block.id}}" style="background-color:{{block.value | hex}};">
														<span class="color-input">
																<input ng-hide="SwatchData.locked" type="text" ng-model="block.value" ng-change="SwatchData.changeblock(block.id,block.value)" class="picker" name="picker-{{block.id}}" value="{{block.value | hex}}" /> 
																<input type="text" onClick="this.select();" class="blabel clippy pointer" title="copy to clipboard" onClick="this.select();" data-clipboard-target="#clip-b{{block.id}}" id="clip-b{{block.id}}" name="value-{{block.id}}" value="{{block.value | hex}}" readonly/> 
														</span>
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
										<p>Your friends need to see this. </p>
										<input id="clip-share" value="{{swatch.url}}" value="{{swatch.url}}" class="clipboard clipboard-text"><button id="clip-share-btn" type='button' class="clippy btn btn-primary clipboard" title="copy url to clipboard" data-clipboard-target="#clip-share">Copy</button>
									<hr/>
									<h2>Clone</h2>
									<p><button class="btn generic" ng-click="SwatchData.clone()" >Click here</button> uplicate this set of colors to a .ew color swatch. </p>
							 	</div>
								<div class="col-md-6">
									<h2>Sass</h2>
									<p><button class="btn generic" href="#nogo" ng-click="swatch.generatesass()" >Generate Sass</button> and paste your variables directly into your project. </p><br/>
									<div ng-show="SwatchData.sass"><textarea id="clip-sass" ng-model="SwatchData.sass" class="clipboard clipboard-textarea" >{{SwatchData.sass}}</textarea><button id="clip-sass-btn" type='button' class="clippy btn btn-primary clipboard" title="copy url to clipboard" data-clipboard-target="#clip-sass">Copy</button></div>
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
							<p>© Copyright <?php echo date("Y"); ?> Company, Inc.</p>
						</footer>
					</div>
				</div>
		</body>
</html>
