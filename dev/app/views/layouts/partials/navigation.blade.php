<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container noPadding">
		<div class="navbar-collapse collapse">
		  <ul class="nav navbar-nav">
		    <li class="{{Request::path() == 'home' ? 'active' : '';}}" ><a href="{{ URL::to('home') }}">home</a></li>
		    <li class="{{Request::path() == 'countries' ? 'active' : '';}}"><a href="{{ URL::to('countries') }}">statistics</a></li>
		    <li><a href="#">livescore</a></li>
		    <li><a href="{{URL::to('/bsim')}}">bsim</a></li>
		    <li><a href="{{URL::to('/sim')}}">sim</a></li>
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