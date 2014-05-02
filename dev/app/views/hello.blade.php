@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array('Home' => URL::to("home"));
		$active = 'hello';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.header', array('calendar' => true, 'big' => "Hello page", 'small' => ''))
@stop

@section('content')
    
    @include('layouts.partials.square', array('data' => $data))

@stop

@section('footer')
	    <script type="text/javascript">
    // Grab all elements with the class "hasTooltip"
    $('.hasTooltip').each(function() { // Notice the .each() loop, discussed below
        $(this).qtip({
            content: {
                text: $(this).attr('title')
            },
        style: {
            classes: 'qtip-light qtip-shadow qtip-rounded'
        },
        position: {
            viewport: $(window)
        }
        });
    });
    </script>
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