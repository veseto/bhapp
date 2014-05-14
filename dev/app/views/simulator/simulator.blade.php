@extends('layout')

@section('breadcrumbs')
	<?php
		$list = array('Home' => URL::to("home"), 'countries' => URL::to('countries'));
		$active = 'Simulator';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => false, 'big' => "Today's matches", 'small' => '28-Apr-14 (Mon)'))
@stop

@section('content')
	<p>
		{{Form::open(array('url' => '/simulator'))}}

		{{Form::label('country', 'Country')}}
		{{Form::text('country', $country)}}<br>

		{{Form::label('league', 'League')}}
		{{Form::text('league', $league)}}<br>

		{{Form::label('season', 'season')}}
		{{Form::text('season', $season)}}<br>

		{{Form::label('count', 'length')}}
		{{Form::text('lt', $lt)}}
		{{Form::text('count', $count)}}<br>

		{{Form::label('offset', 'offset')}}
		{{Form::text('offset', $offset)}}<br>

		{{Form::label('multiply', 'multiplier')}}
		{{Form::text('multiply', $multiply)}}<br>

		{{Form::label('init', 'Initial')}}
		{{Form::text('init', $init)}}<br>

		{{Form::submit('Start new sim')}}
		{{Form::close()}}<br>
	</p>
	@if(isset($data))
		<table id="sim">
		
		<tbody>
			@foreach($data as $season=>$dd)
				@foreach($dd as $round=>$d)
					<tr>
						<td>{{$season}}</td>
						<td>{{$round}}</td>
						<td>{{$d['bsf']}}</td>
						<td>{{$d['adj']}}</td>
						<td>{{$d['bet']}}</td>
						<td>{{$d['acc']}}</td>
						<td>{{$d['all_draws']}}/{{$d['all_matches']}}</td>
						<td>{{$d['draws_played']}}/{{$d['all_played']}}</td>
						<td>{{$d['income']}}</td>
						<td>{{$d['real']}}</td>
					</tr>
				@endforeach
			@endforeach
			</tr>
		</tbody>
		<thead>
			<tr>
				<th>season</th>
				<th>round</th>
				<th>bsf</th>
				<th>adjustments</th>
				<th>bet</th>
				<th>acc</th>
				<th>matches</th>
				<th>series</th>
				<th>income</th>
				<th>acc state</th>
			</tr>
		</thead>
	</table>

	<script type="text/javascript">
	function fnFormatDetails ( oTable, nTr )
	{
		var text = '';
		var aData = oTable.fnGetData( nTr );
		var team = '';
		if (aData[5].indexOf("<strong>") > -1) {
			  var re = new RegExp("<strong>(.*?)\\s<");
			  var m = re.exec(aData[5]);
			  team = m[1];
		} else if (aData[7].indexOf("<strong>") > -1) {
			  var re = new RegExp("<strong>(.*?)\\s<");
			  var m = re.exec(aData[7]);
			  team = m[1];
		}
		var promise = testAjax(team, aData[2]);
		promise.success(function (data) {
		  text = data;
		});
		return text;
	}


	$( "tbody>tr" ).hover(
		function() {
			var claz = $(this).attr('class');
			var st = claz.split(' ');
			var firstClass = st[0];

			var id="."+firstClass;
			//alert(id);
			if ($(id).length > 1) {
				$(id+">td").addClass("text-danger");
			}
			//$(id).attr("style", "color: red");
			//$( this ).append( $( "<span> ***</span>" ) );
		}, function() {
			var claz = $(this).attr('class');
			var st = claz.split(' ');
			var firstClass = st[0];

			var id="."+firstClass;
			//alert(id);
			$(id+">td").removeClass("text-danger");
			//$(id).addClass("test");			
		}
	);

	var asInitVals = new Array();

	$(document).ready(function(){
		var oTable = $("#sim").dataTable({
	    	    "iDisplayLength": 100,
	    	    "bJQueryUI": true,
	    	    "sPaginationType": "full_numbers",
	    	    "sDom": '<"top" Tlf>irpti<"bottom"pT><"clear">',
					"oTableTools": {
						"sSwfPath": "/swf/copy_csv_xls_pdf.swf"
					}
			});
		$("thead input").keyup( function () {
		/* Filter on the column (the index) of this element */
			oTable.fnFilter( this.value, $("thead input").index(this));
		} );
		
		/*
		 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
		 * the footer
		 */
		$("thead input").each( function (i) {
			asInitVals[i] = this.value;
		} );
		
		$("thead input").focus( function () {
			if ( this.className == "search_init" )
			{
				this.className = "";
				this.value = "";
			}
		} );
		
		$("thead input").blur( function (i) {
			if ( this.value == "" )
			{
				this.className = "search_init";
				this.value = asInitVals[$("thead input").index(this)];
			}
		} );
	});
	</script>
	@endif
@stop
