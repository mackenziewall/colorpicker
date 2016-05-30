<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HueHueHue</title>
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
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li><a href="#new">New</a></li>
                <li><a href="#lock"><i class="fa fa-lock" aria-hidden="true"></i> Lock</a></li>
                <li><a href="#sass"><i class="fa fa-file-text-o" aria-hidden="true"></i> Sass</a></li>
                <li><a href="#share"><i class="fa fa-link" aria-hidden="true"></i> Share</a></li>
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
                                <input type="text" class="blabel" name="value-{{block.id}}" value="#{{block.value}}" disabled/> 
                            </span>
                            <a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </span>
                </div>
                <div class="endblock block"><a href="#add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </body>
</html>
