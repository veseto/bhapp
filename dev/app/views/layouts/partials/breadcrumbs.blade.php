<div class="row">
	<ol class="breadcrumb noPadding">
	@foreach(array_get($elements, 'list') as $name => $url)
		<li><a href="{{$url}}">{{$name}}</a></li>
	@endforeach
	<li class="active">{{array_get($elements, 'active')}}</li>
	</ol>
	<div class="pull-right">
		<span>{{ Auth::user()->name }} | <a href="/settings">settings</a> | <a href="/logout">log out</a></span>
	</div>
</div>