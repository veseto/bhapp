@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<div class="container">
	  <ol class="breadcrumb">
	    <li><a href="#">Home</a></li>
	    <li><a href="#">Germany</a></li>
	    <li><a href="#">3.Liga</a></li>
	    <li class="active">Fixtures</li>
	  </ol>
	  <div class="pull-right">
	    <span>fefence | <a href="#">settings</a> | <a href="#">log out</a></span>
	  </div>
	</div>
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
	    <div class="col-xs-3" style="padding-top:4px;text-align:right;">
			<span><a href="#" class="btn-sm btn-default"><</a></span>&nbsp;<span><a href="#" class="btn-sm btn-default">today</a>&nbsp;<a href="#" class="btn-sm btn-default">>></a>
	    </div>
	    <div class="col-xs-3 noMarginPadding">
	      <!-- calendar -->
	      <div class="form-group pull-right" id="datepickid">
	        <div class="input-group date">
	          <input type="text" class="form-control input-sm"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
	        </div>
	      </div>
	    </div>
	  </div>
	  
	  <hr/>
@stop

@section('content')

	<div class="row">
		<div class="col-xs-3 text-center">
			Country		
		</div>
		<div class="col-xs-3 text-center">
			League		
		</div>
		<div class="col-xs-3 text-center">
			Year		
		</div>
		<div class="col-xs-3">
					
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<div class="list-group" style="height:175px; width:250px;overflow:scroll;">
			@foreach($countries as $country)
		       <a href="#" class="list-group-item country" style="height:30px; line-height: 10px;">{{$country->country}}</a>
		    @endforeach
			</div>
		</div>
		<div class="col-xs-3">
			<div class="list-group" style="height:175px; width:250px;overflow:scroll;">
			@foreach($countries as $country)
		       <a href="{{$country->country}}" class="list-group-item" style="height:30px; line-height: 10px;">{{$country->country}}</a>
		    @endforeach
			</div>
		</div>
		<div class="col-xs-3">
			<div class="list-group" style="height:175px; width:250px;overflow:scroll;">
			@foreach($countries as $country)
		       <a href="{{$country->country}}" class="list-group-item" style="height:30px; line-height: 10px;">{{$country->country}}</a>
		    @endforeach
			</div>
		</div>
		<div class="col-xs-3">
		</div>
	</div>
@stop

@section('footer')
	    <div id="footer">
	      <div class="container">
	        <p class="text-muted"> today's matches: <strong><a href="#">43</a></strong><strong> | </strong>BSF for today's matches: <strong>2213€</strong><strong> | </strong>Total BSF: <strong>5346€</strong></p>
	      </div>
	    </div>
	<script type="text/javascript">
	$(document).ready({
		$('#country').on('click', function(){
			alert("noooo");
		});
	});

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