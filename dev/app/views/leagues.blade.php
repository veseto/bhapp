@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	
	<?php
		$list = array('Home' => URL::to("home"), 'countries' => URL::to('countries'));
		$active = array_get($data, 'country');
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.header', array('calendar' => true, 'big' => "Archive", 'small' => array_get($data, 'country')))
@stop
@section('content')
    @foreach(array_get($data, 'leagues') as $league)
    	<a href="{{ URL::route('archive', array('country' => $league->country, 'league' => $league->fullName)) }}">{{ $league->fullName }}</a><br>
 	@endforeach
@stop

@section('footer')
	    
	<script type="text/javascript">

	  $('#datepickid div').datepicker({
	    format: "dd.mm.yy",
	    weekStart: 1,
	    orientation: "top auto",
	    // autoclose: false,
	    todayHighlight: true,
	    multidate: true,
	    multidateSeparator: " to ",
	    beforeShowDay: function (date) {
	      if (date.getMonth() == (new Date()).getMonth())
	        switch (date.getDate()){
	          case 4:
	            return {
	              tooltip: 'Example tooltip',
	              classes: 'text-danger'
	            };
	          case 8:
	            return false;
	          case 12:
	            return "green";
	        }
	    }
    });
	</script>
@stop