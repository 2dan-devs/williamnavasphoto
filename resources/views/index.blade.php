<!doctype html>
<html class="no-js" lang="en" ng-app="wnp">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="robots" content="index,follow">
		<meta name="description" content="photography services for all occasions, portraits, weddings, events, family.">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="304Fix" content="safari-fix">
		<link href='http://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="fe/css/font-awesome.min.css">
		<link rel="stylesheet" href="fe/css/foundation.min.css"/>
		<link rel="stylesheet" href="fe/css/main.css"/>
		<script src="fe/js/modernizr.js"></script>
	</head>
	<body ng-controller="HomeCtrl">
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Navigation Sidebar -->
	        <nav id="side-nav">
				<div class="logo" ng-click="toggleObject.item = -1">
					<a href="#/">William Navas <span style="color:#D94141">Photo</span></a>
				</div>
				<ul id="gallery-menu">
					<li ng-repeat="album in albums" ng-if="$index > 0">
						<a ng-href="#/gallery/@{{album.id}}" ng-click="toggleObject.item = $index" ng-class="{'active':toggleObject.item == $index}">
							@{{album.name}}</a>
					</li>
				</ul>
				<ul id="links-menu">
					<li><a href="user/dashboard">Client Area</a></li>
					<li ng-click="toggleObject.item = 22">
						<a href="#/contact" ng-class="{'active':toggleObject.item == 22}">Contact</a>
					</li>
					<li ng-click="toggleObject.item = 33">
						<a href="#/about" ng-class="{'active':toggleObject.item == 33}">About</a>
					</li>
				</ul>
				<ul class="social-icons">
                    <li><a href="https://www.facebook.com/pages/William-Navas-Photo/201253276656084"
                    	target="blank" class="fa fa-lg fa-facebook"></a>
                    </li>
                    <li><a href="https://www.flickr.com/photos/williamnavasphoto/" target="blank" class="fa fa-lg fa-flickr"></a></li>
                    <li><a href="https://instagram.com/wil_nvs_photo/" target="blank" class="fa fa-lg fa-instagram"></a></li>
                	<li><a href="#/" class="fa fa-lg fa-twitter"></a></li>
                </ul>

	        </nav> <!-- End navigation sidebar -->

			<!-- Partial are inserted here -->
			<div id="main-view" ng-view=""></div>
			
			<!-- Footer -->	
			<p id="footer">&copy; William Navas Photo 2015. All rights reserved. Designed and developed by
			<a href="http://danilonavas.net" target="blank" style="color:#D94141">D.Navas</a> and 
			<a href="http://danielsilver.net" target="blank" style="color:#D94141">D.Silver</a>.</p>	
				
			<!-- Scripts -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.min.js"></script>
		        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-sanitize.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-touch.min.js"></script>
			<script src="fe/js/App.js"></script>
			<script src="fe/js/LoadingDirective.js"></script>
			<script src="fe/js/ImageZoom.js"></script>
			<script src="fe/js/SharedServices.js"></script>
			<script src="fe/js/HomeCtrl.js"></script>
			<script src="fe/js/GalleryCtrl.js"></script>
			<script src="fe/js/ContactCtrl.js"></script>
			<script src="fe/js/AboutCtrl.js"></script>
			<script src="fe/js/routes.js"></script>
			<script>
    			document.oncontextmenu = new Function("return false;");
			</script>
			<!-- End Scripts -->
		</div>
		<!-- End Wrapper -->
	</body>
</html>