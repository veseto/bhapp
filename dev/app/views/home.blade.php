@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array();
		$active = 'Home';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => true, 'big' => "Today's matches", 'small' => '28-Apr-14 (Mon)'))
@stop

@section('content')
	
	 {{ Datatable::table()
    ->addColumn('date', 'time', 'home', 'away', 'result', 'length', 'game type')       // these are the column headings to be shown
    ->setUrl("/api/matches/$from/$to")   // this is the route where data will be retrieved
    ->render('dt.template') }}
@stop
