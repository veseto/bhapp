@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<div class="container">
	  <ol class="breadcrumb">
	    <li class="active">Home</li>
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
			<span><a href="#" class="btn-sm btn-default"><<</a></span>&nbsp;<span><a href="#" class="btn-sm btn-default">today</a>&nbsp;<a href="#" class="btn-sm btn-default">>></a>
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
	
	 {{ Datatable::table()
    ->addColumn('home','away')       // these are the column headings to be shown
    ->setUrl(route('api.matches'))   // this is the route where data will be retrieved
    ->render() }}
@stop

@section('footer')
	    <div id="footer">
	      <div class="container">
	        <p class="text-muted"> today's matches: <strong><a href="#">43</a></strong><strong> | </strong>BSF for today's matches: <strong>2213€</strong><strong> | </strong>Total BSF: <strong>5346€</strong></p>
	      </div>
	    </div>
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