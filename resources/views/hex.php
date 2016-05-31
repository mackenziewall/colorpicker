<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HueHueHue</title>
        <base href="/home.php" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <script type="text/javascript" src="/js/spectrum.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/spectrum.css">
        <script type="text/javascript" src="/js/app.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>
    <body role="document" ng-app="colorpicker">
        <!-- Fixed navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
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
                <li><a type='button' ng-click="navigation.refresh()"><i class="fa fa-code-fork" aria-hidden="true"></i> <span class="nav-label">Refresh</span></a></li>
                <li><a type='button' ng-click="navigation.fork()"><i class="fa fa-code-fork" aria-hidden="true"></i> <span class="nav-label">Fork</span></a></li>
                <li><a type='button' ng-click="navigation.lock()"><i class="fa fa-lock" aria-hidden="true"></i> <span class="nav-label">Lock</span></a></li>
                <li><a type='button' ng-click="navigation.clipSass()"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span class="nav-label">Sass</span></a></li>
                <li><a type='button' ng-click="navigation.clipLink()"><i class="fa fa-link" aria-hidden="true"></i> <span class="nav-label">Share</span></a></li>
                <!--<li><a href="#contact"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a></li> Just kidding don't contact me -->
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div class="container theme-showcase" ng-controller="SwatchController as swatch">
            <div class="swatch">
                <div class="startblock block"></div>
                <div class="blockbucket">
                    <span ng-repeat="block in swatch.blocks" repeat-done="layoutDone()">
                        <div class="colorblock block" id="block{{block.id}}" style="background-color:#{{block.value}};">
                            <span class="color-input">
                                <input type="text" class="picker" name="picker-{{block.id}}" value="#{{block.value}}" /> 
                                <input type="text" class="blabel pointer" name="value-{{block.id}}" value="#{{block.value}}" disabled/> 
                            </span>
                            <a class="delete pointer"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </span>
                </div>
                <div class="endblock block"><a type='button' ng-click="swatch.add()" class="addnew pointer"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </body>
</html>
