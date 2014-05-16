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
	@include('layouts.partials.pageheader', array('calendar' => false, 'big' => $country.' :: '.$league, 'small' => $seasoncount.' seasons'))
@stop

@section('content')

<table class='simulator'>
		{{Form::open(array('url' => $action."/".$country."/".$league))}}
	<tr>
		<td class="leading">{{Form::label('country', 'Country')}}</td>
		<td>{{Form::text('country', $country, array('readonly'))}}</td>
	</tr>
	<tr>
		<td>{{Form::label('league', 'League')}}</td>
		<td>{{Form::text('league', $league, array('readonly'))}}</td>
	</tr>
	<tr>
		<td>{{Form::label('seasoncount', 'Available seasons')}}</td>
		<td>{{Form::text('seasoncount', $seasoncount, array('readonly'))}}</td>
	</tr>
	<tr>
		<td>{{Form::label('seasonfrom', 'From season')}}</td>
		<td>{{Form::text('seasonfrom', $seasonfrom)}}</td>
	</tr>
	<tr>
		<td>{{Form::label('season', 'To season')}}</td>
		<td>{{Form::text('season', $season)}}</td>
	</tr>
	<tr>
		<td>{{Form::label('count', 'Length')}}</td>
		<td>{{Form::text('lt', $lt, array('class' => 'direction'))}}{{Form::text('count', $count, array('class' => 'length'))}}</td>
	</tr>
	<tr>
		<td>{{Form::label('offset', 'Starting round')}}</td>
		<td>{{Form::text('offset', $offset)}}</td>
	</tr>
	<tr>
		<td>{{Form::label('bsf', 'BSF')}}</td>
		<td>{{Form::text('bsf', $bsf)}}</td>
	</tr>
	<tr>
		<td>{{Form::label('multiply', 'Multiplier')}}</td>
		<td>{{Form::text('multiply', $multiply)}}</td>
	</tr>
	<tr>
		<td>{{Form::label('init', 'Initial €')}}</td>
		<td>{{Form::text('init', $init)}} </td>
	</tr>
	<tr>
		<td></td>
		<td>{{Form::submit('Start')}}</td>
	</tr>
		@if(isset($data))
		{{Form::close()}}
</table>


		<table id="sim">
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
						<td>{{$d['all_draws']}} ({{$d['all_matches']}})</td>
						<td>{{$d['draws_played']}} ({{$d['all_played']}})</td>
						<td>{{$d['income']}}</td>
						<td>{{$d['real']}}</td>
					</tr>
				@endforeach
			@endforeach
			</tr>
		</tbody>
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
	@if(isset($time)) 
		Time elapsed: {{$time}} sec
	@endif
@stop
