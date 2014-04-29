<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            @section('title')
			bhapp
            @show
        </title>
	    <meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- css -->
        {{ HTML::style('css/bootstrap.min.css') }}
        {{ HTML::style('css/custom.css') }}
        {{ HTML::style('css/datepicker3.css') }}
        {{ HTML::style('css/datatables.css') }}
        {{ HTML::style('css/datatables_themeroller.css') }}
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>


	<body>  
	        {{ HTML::script('js/jquery-1.11.0.min.js') }}

	<!-- navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top mainNav" role="navigation">
	  <div class="container">
	    <div class="navbar-collapse collapse">
	      <ul class="nav navbar-nav">
	        <li class="{{Request::path() == 'home' ? 'active' : '';}}"><a href="{{ URL::to('home') }}">home</a></li>
	        <li class="{{Request::path() == 'countries' ? 'active' : '';}}"><a href="{{ URL::to('countries') }}">statistics</a></li>
	        <li><a href="#">livescore</a></li>
	        <li><a href="#">streaks</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li class="dropdown-header">Nav header</li>
	            <li><a href="#">Separated link</a></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown">dropdown <b class="caret"></b></a>
	          <ul class="dropdown-menu">
	            <li><a href="#">Action</a></li>
	            <li><a href="#">Another action</a></li>
	            <li><a href="#">Something else here</a></li>
	            <li class="divider"></li>
	            <li class="dropdown-header">Nav header</li>
	            <li><a href="#">Separated link</a></li>
	            <li><a href="#">One more separated link</a></li>
	          </ul>
	        </li>
	        <li><a href="#">money</a></li>
	        <li><a href="#">money</a></li>
	      </ul>
	    </div><!--/.nav-collapse -->
	  </div>
	</div>

        @yield('breadcrumbs')

        @yield('pageHeader')

        @yield('content')
    </div>

        {{ HTML::script('js/datatables.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap-datepicker.js') }}
        {{ HTML::script('js/datatables.js') }}
        
        @yield('footer')
    </body>
</html>