@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array('Home' => URL::to("home"));
		$active = 'matches';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => true, 'big' => "Today's matches", 'small' => '28-Apr-14 (Mon)'))
@stop

@section('content')
	
	 {{ Datatable::table()
    ->addColumn('date', 'time', 'home', 'away', 'home FT', 'away FT')       // these are the column headings to be shown
    ->setUrl(route('api.matches'))   // this is the route where data will be retrieved
    ->render() }}
@stop
