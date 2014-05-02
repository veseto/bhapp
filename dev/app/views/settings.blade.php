@extends('layout')

@section('breadcrumbs')
	<?php
		$list = array('home' => URL::to("home"));
		$active = 'settings';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => false, 'big' => "Settings", 'small' => Auth::user()->name))
@stop

@section('content')

@stop

@section('footer')
	    
@stop