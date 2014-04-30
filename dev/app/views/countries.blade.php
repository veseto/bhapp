@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<div class="container">
	  <ol class="breadcrumb">
	   	<li><a href="{{ URL::to('home') }}">Home</a></li>
	    <li class="active">Countries</li>
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
			<span><a href="#" class="btn-sm btn-default"><</a></span>&nbsp;<span><a href="#" class="btn-sm btn-default">today</a>&nbsp;<a href="#" class="btn-sm btn-default">></a>
	    </div>
	    <div class="col-xs-3 noMarginPadding">
	      <!-- calendar -->
	      <div class="form-group pull-right" id="datepickid">
	        <div class="input-group date">
				<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
	        	<input type="text" class="form-control input-sm" style="height: 36px; font-size: 110%;" disabled="disabled">
				<span class="input-group-addon"><a href="#" class="btn btn-xs">GO</a></span>
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
			<div class="list-group" style="height:200px;overflow:scroll;">
			@foreach($data as $country => $leagues)
		       <a class="list-group-item country" style="">{{$country}}</a>
		    @endforeach
		    
			</div>
		</div>
		<div class="col-xs-3">
			<div class="list-group leagues-container" style="height:200px;overflow:scroll;">
			</div>
		</div>
		<div class="col-xs-3">
			<div class="list-group years-container" style="height:200px;overflow:scroll;">
			
			</div>
		</div>
		<div class="col-xs-3">
			<form id='a' method='POST'>
				<input type="hidden" id='hidden_country'>
				<input type="hidden" id='hidden_league'>
				<input type="hidden" id='hidden_year'>
			</form>
			<a href="" id="hidden">GO</a>
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
		var arrayFromPHP = <?php echo json_encode($data) ?>;
			var arr = new Array();
			arr.push(arrayFromPHP);
		
		$(document).delegate('.season', 'click', function(){
	    	
	    	$(".season").removeClass('active');
				$(this).addClass("active");
				var text = $(this).text();
				$("#hidden_year").val(text);
				$('#hidden').attr('href', $("#hidden_country").val()+"/"+$("#hidden_league").val()+"/"+$("#hidden_year").val()+"/stats");
		}); 
		$(document).delegate('.league', 'click', function(){
	    	
	    	$(".league").removeClass('active');
				$(this).addClass("active");
				var text = $(this).text();
				$("#hidden_league").val(text);
				var country =$("#hidden_country").val();
				// alert(country);
				var seasons = arr[0][country][text];
				// alert(leagues[0]);
				var container = $(".years-container");
				container.empty();
				container.append('<a class="list-group-item season active">'+seasons[0]+"</a>");
				$("#hidden_year").val(seasons[0]);
				$('#hidden').attr('href', $("#hidden_country").val()+"/"+$("#hidden_league").val()+"/"+$("#hidden_year").val()+"/stats");
				for(var i = 1; i < seasons.length; i ++) {
					container.append('<a class="list-group-item season">'+seasons[i]+"</a>");
				}
				
		}); 
		$(function(){	
			$(".country").on("click", function(){
				$(".country").removeClass('active');
				$(".league").removeClass('active');
				$(this).addClass("active");
				var text = $(this).text();
				$("#hidden_country").val(text);
				
				var leagues = arr[0][text];
				var container = $(".leagues-container");
				container.empty();
				$(".years-container").empty();
				$.each(leagues, function(key, value) {
					container.append('<a class="list-group-item league">'+key+"</a>");
				});
			});
			
		});	
		$('#datepickid div').datepicker({
			format: "dd.mm.yy",
			weekStart: 1,
			orientation: "top left",
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