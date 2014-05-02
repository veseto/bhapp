@extends('layout')

@section('breadcrumbs')
	<?php
		$list = array();
		$active = 'Home';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	<div class="container">
	  <div class="row">
	    <div class="col-xs-6 noMarginPadding">
	      <!-- main content -->
	      <div class="page-header">
	        <h3 class="noMarginPadding">Today's matches <small>28-Apr-14 (Mon)</small></h3>
	      </div>
	    </div>
	    @include('layouts.partials.calendar')
	  </div>
	  
	  <hr/>
@stop

@section('content')
  
  	@if (Session::get('flash_message'))
		{{ Session::get('flash_message') }}
	@endif
	
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