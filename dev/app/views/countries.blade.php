@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array('home' => URL::to("home"));
		$active = 'countries';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => true, 'big' => "Statistics", 'small' => ''))
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
				container.append('<a class="list-group-item season active" onclick="">'+seasons[0]+"</a>");
				$("#hidden_year").val(seasons[0]);
				$('#hidden').attr('href', $("#hidden_country").val()+"/"+$("#hidden_league").val()+"/"+$("#hidden_year").val()+"/stats");
				for(var i = 1; i < seasons.length; i ++) {
					container.append('<a class="list-group-item season" onclick="">'+seasons[i]+"</a>");
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
					container.append('<a class="list-group-item league" onclick="">'+key+"</a>");
				});
			});
			
		});	
	</script>
@stop