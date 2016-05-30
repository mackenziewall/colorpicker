<!DOCTYPE html>
<html lang="en">
    <head>
        <title>HueHueHue</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <script type="text/javascript" src="/js/spectrum.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/spectrum.css">
        <style>
        body{padding-top:60px;background-color:#EEE;}
        .block{display:inline-block;float:left;position:relative;}
        .colorblock{height:150px;width:183px;}
        .block:hover .color-input{opacity:1;}
        .color-input{
            position:absolute; 
            bottom:0;
            margin-left:0;
            margin-right:0;
            width:100%;
            left:5px;
            font-size:32px; 
            font-family: 'Oswald', sans-serif;
            color: black;
            -webkit-text-fill-color: white; /* Will override color (regardless of order) */
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;
            font-size:22px;
        }
        .color-input input{width:94%;font-size:32px; background-color:transparent;border:none;text-align:center;}
        .swatch{
            display:inline-block;
            position:relative;
            margin:0;
            background-color: #fff;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            -webkit-box-shadow: rgba(0,0,0,0.2) 0px 0 10px;
            -moz-box-shadow: rgba(0,0,0,0.2) 0 0 10px;
            box-shadow: rgba(0,0,0,0.2) 0 0 10px;
        }
        .delete:hover{color:#C00;-webkit-text-fill-color: #C00;}
        .delete {font-size:26px; padding-bottom:12px; box-shadow: none;color:red; border:none;position:absolute;top:0;right:5px;
            -webkit-text-fill-color: red; /* Will override color (regardless of order) */
            -webkit-text-stroke-width: 1px;
            -webkit-text-stroke-color: black;}
        #b1{background-color:#F00;}
        #b2{background-color:#55F;}
        #b3{background-color:#872;}
        .startblock, .endblock {background-color:#FFF;}
        @media (min-width:768px){
            .addnew{position:absolute;top:42%;right:4px;}
            .startblock, .endblock {height:150px;width:20px;}
            .endblock{
                -webkit-border-top-right-radius: 10px;
                -webkit-border-bottom-right-radius: 10px;
                -moz-border-radius-topright: 10px;
                -moz-border-radius-bottomright: 10px;
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
            }
            .startblock{
                -webkit-border-top-left-radius: 10px;
                -webkit-border-bottom-left-radius: 10px;
                -moz-border-radius-topleft: 10px;
                -moz-border-radius-bottomleft: 10px;
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
            }
            .blockbucket{padding:0 20px;}
        }
        @media (max-width:767px){
            .swatch{display:block;width:100%;max-height:500px;}
            .color-input input{width:98% !important;}
            .block{display:block;width:100% !important;}
            .startblock, .endblock {min-height:20px;height:20px;width:200px;}
            .startblock{-webkit-border-top-left-radius: 10px;
            -webkit-border-top-right-radius: 10px;
            -moz-border-radius-topleft: 10px;
            -moz-border-radius-topright: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;}
            .endblock{
                padding-top:5px;
                height:30px;
                text-align:center;
                -webkit-border-bottom-right-radius: 10px;
                -webkit-border-bottom-left-radius: 10px;
                -moz-border-radius-bottomright: 10px;
                -moz-border-radius-bottomleft: 10px;
                border-bottom-right-radius: 10px;
                border-bottom-left-radius: 10px;
            }
            .addnew{
              position:relative;
              margin-right:auto !important;
              margin-left:auto !important;
            }
        }

        </style>
    </head>
    <body role="document" ng-app>
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
                <li><a href="#contact"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>
        <div class="container theme-showcase" ng-app="huehuehue">
            <div class="swatch">
                <div class="startblock block"></div><div class="blockbucket">
                <div class="colorblock block" id="b1" style="background-color:#F00;"><span class="color-input"><input name="value-b1" value="#1F2030" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b2" style="background-color:#55F;"><span class="color-input"><input name="value-b2" value="#15253F" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b3" style="background-color:#872;"><span class="color-input"><input name="value-b3" value="#182732" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b1" style="background-color:#F00;"><span class="color-input"><input name="value-b1" value="#1F2030" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b2" style="background-color:#55F;"><span class="color-input"><input name="value-b2" value="#15253F" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b3" style="background-color:#872;"><span class="color-input"><input name="value-b3" value="#182732" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b1" style="background-color:#F00;"><span class="color-input"><input name="value-b1" value="#1F2030" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b2" style="background-color:#55F;"><span class="color-input"><input name="value-b2" value="#15253F" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                <div class="colorblock block" id="b3" style="background-color:#872;"><span class="color-input"><input name="value-b3" value="#182732" disabled/> </span><a href="#del" class="delete"><i class="fa fa-times" aria-hidden="true"></i></a></div>
                </div><div class="endblock block"><a href="#add" class="addnew"><i class="fa fa-plus" aria-hidden="true"></i></a></div>
            </div>
        </div>
    </body>
</html>
