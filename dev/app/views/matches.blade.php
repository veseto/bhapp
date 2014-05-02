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
	@include('layouts.partials.header', array('calendar' => true, 'big' => "Today's matches", 'small' => '28-Apr-14 (Mon)'))
@stop

@section('content')
	
	 {{ Datatable::table()
    ->addColumn('date', 'time', 'home', 'away', 'home FT', 'away FT')       // these are the column headings to be shown
    ->setUrl(route('api.matches'))   // this is the route where data will be retrieved
    ->render() }}
@stop

@section('footer')
	    
	<script type="text/javascript">
	// $(document).ready(function(){
	// 	$('#country').on("click", function(){
 //        	alert("boo");
 //        });
	// });

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