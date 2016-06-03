<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HueHueHue</title>
        <base href="/home.php" />
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
        <nav class="navbar navbar-inverse navbar-fixed-top navbar-default navbar-brand">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">HueHueHue</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" ng-controller="navigationController as navigation">
              <ul class="nav navbar-nav">
                <li><a href="/create"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="nav-label">New</span></a></li>
                <li><a type='button' ng-click="navigation.clone()"><i class="fa fa-clone" aria-hidden="true"></i> <span class="nav-label">Clone</span></a></li>
                <li><a type='button' ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
                <li><a type='button' class="clippy" title="copy sass variables to clipboard" data-clipboard-target="#clip-sass"><i class="fa fa-align-left" aria-hidden="true"></i> <span class="nav-label">Sass</span> <input id="clip-sass" class="sneaky" value="{{navigation.sass}}" ng-model="navigation.sass" ></a></li>
                <li><a type='button' class="clippy" title="copy url to clipboard" data-clipboard-target="#clip-share"><i class="fa fa-link" aria-hidden="true"></i> <span class="nav-label">Share </span><input id="clip-share" class="sneaky" value="{{navigation.url}}" ng-model="navigation.url" ></a></li>
                <!--<li><a href="#contact"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a></li> Just kidding don't contact me -->
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div class="container theme-showcase" ng-controller="SwatchController as swatch">
            <div class="swatch" ng-show="SwatchData.blocks" >
                <div class="startblock block"></div>
                <div class="blockbucket">
                    <span ng-repeat="block in SwatchData.blocks" repeat-done="layoutDone()">
                        <div ng-hide="block.value == ''" class="colorblock block" id="block{{block.id}}" style="background-color:{{block.value | hex}};">
                            <span class="color-input">
                                <input ng-hide="SwatchData.lock" type="text" ng-model="block.value" ng-change="SwatchData.changeblock(block.id,block.value)" class="picker" name="picker-{{block.id}}" value="{{block.value | hex}}" /> 
                                <input type="text" onClick="this.select();" class="blabel clippy pointer" title="copy to clipboard" onClick="this.select();" data-clipboard-target="#clip-b{{block.id}}" id="clip-b{{block.id}}" name="value-{{block.id}}" value="{{block.value | hex}}" readonly/> 
                            </span>
                            <a ng-hide="SwatchData.lock || SwatchData.singleblock()" ng-click="SwatchData.deleteblock(block.id)" class="delete pointer"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </span>
                </div>
                <div class="endblock block"><a type='button' ng-hide="SwatchData.lock" ng-click="SwatchData.addblock()" class="addnew pointer"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
            </div>
        </div>
        <div class="container theme-showcase"></div>
    </body>
</html>
