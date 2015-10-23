<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>William Navas Photo</title>
	<!-- Tell search engines not to follow or index admin pages -->
	<meta name="robots" content="noindex,nofollow"/>

	<!--############## STYLES AND SCRIPTS THAT MUST BE LOADED BEFORE BODY ############-->
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('admin/bower_components/foundation/css/foundation.css') }}">
	<!-- Normalize 3.0.2 CSS -->
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('admin/bower_components/foundation/css/normalize.css') }}">
	<!-- Modernizr 2.8.3 JS -->
	<script src="{{ url('admin/bower_components/modernizr/modernizr.js') }}"></script>
	<!-- jQuery-UI Smoothnees Theme -->
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('admin/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css') }}">
	<!-- Custom CSS file for "master.blade.php" -->
	<link media="all" type="text/css" rel="stylesheet" href="{{ url('css/admin-master.css')}}">
	<!-- font awesome -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<!-- Allow views to load custom view specific styles -->
	@yield('styles')
</head>
<body>
<!-- Top Banner -->
<div class="top-banner">
	<div class="row">
		<h1 class="top-banner-text1">William Navas Photo</h1>
	</div>
</div>

<!-- Navigation Bar -->
<div class="contain-to-grid">
		<nav class="top-bar" data-topbar role="navigation">
	  <ul class="title-area">
	    <li class="name">
	      <h1><a href="{{ url() }}">Home</a></h1>
	    </li>
	     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
	    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	  </ul>

	  <section class="top-bar-section">
	    <!-- Right Nav Section -->
	    <ul class="right">
	      <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
	    </ul>

	    <!-- Left Nav Section -->
	    <ul class="left">
	      <li><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
	    </ul>
	  </section>
	</nav>
</div>
<!-- End navigation bar -->

<!-- Main Content -->
    <div class="row">
        <div class="large-12 columns view-title">
            <br>
            <!-- Title from View -->
            <h3><b>{{$title}}</b></h3>
            <br>
            <!-- Show session messages -->
            @if (Session::has('message')) {!! Session::get('message') !!} @endif
        </div>

        <!-- Show validation errors -->
        @if($errors->all())
        <div class="large-12 columns">
            <div class="alert-box alert val-top-box-errors">
            <a class="fa fa-large fa-times fa-inverse right" id="session-message-alert"></a>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <!-- Main Content -->
        <div class="large-12 columns">
            @yield('content')
        </div>
    </div>


<!-- Footer -->
<div>
	<p id="footer">&copy; William Navas Photo 2015. All rights reserved. Designed and developed by
                    <a href="http://danilonavas.net" target="blank">D.Navas</a> and 
                    <a href="http://danielsilver.net" target="blank">D.Silver</a>.</p>
</div>

	<!--############### SCRIPTS THAT CAN BE LOADED AFTER PAGE LOADS ###############-->
	<!-- jQuery 2.1.3 -->
	<script src="{{ url('admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<!-- jQuery-UI 1.11.2 -->
	<script src="{{ url('admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
	<!-- FastClick -->
	<script src="{{ url('admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
	<!-- Foundation Responsive JS -->
	<script src="{{ url('admin/bower_components/foundation/js/foundation.min.js') }}"></script>
	<!-- Custom JS file for "master.blade.php" -->
	<script src="{{ url('js/master.js') }}"></script>
	<!-- Allow views to load custom view specific scripts -->
	@yield('scripts')

	<!-- Initialize Foundation Framework -->
	<script>
		$(document).foundation();
	</script>
	<!-- End Foundation Initialization -->
</body>
</html>
