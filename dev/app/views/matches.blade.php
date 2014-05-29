@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array();
		$active = 'Home';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => true, 'big' => "Today's matches", 'small' => '28-Apr-14 (Mon)'))
@stop

@section('content')
	<!-- {{ Form::open(array('url' => '/pools/get')) }}
	    
	{{ Form::label('amount', 'Amount') }}
	{{ Form::text('amount') }}

	{{ Form::hidden('league', $league_details_id) }}
	
	{{ Form::submit('get') }}

	{{ Form::close() }}
 -->
	<table id="matches">
		<thead>
			<tr>
				<th><input type="text" name="search_engine" class="search_init" placeholder="date"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="time"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="home"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="away"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="res"></th>
				<th><input type="hidden"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="game"></th>
				<th><input type="text" name="search_engine" class="search_init" placeholder="bookmaker"></th>
				<th><input type="hidden"></th>
				<th><input type="hidden"></th>
				<th><input type="hidden"></th>
				<th><input type="hidden"></th>
				<th><input type="hidden"></th>
				<th><input type="hidden"></th>
			</tr>
			<tr>
				<th>date</th>
				<th>time</th>
				<th>home</th>
				<th>away</th>
				<th>result</th>
				<th>length</th>
				<th>game</th>
				<th>bookmaker</th>
				<th>bsf</th>
				<th>bet</th>
				<th>odds</th>
				<th>income</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach($data as $d)
				<tr class="{{$d->match_id}}" id="{{$d->games_id}}">
					<td>{{$d->matchDate}}</td>
					<td>{{$d->matchTime}}</td>
					<td>
						@if ($d->team == $d->home)
							<strong>{{$d->home}}</strong>
						@else
							{{$d->home}}
						@endif
					</td>
					<td>
						@if ($d->team == $d->away)
							<strong>{{$d->away}}</strong>
						@else
							{{$d->away}}
						@endif
					</td>
					<td>{{$d->resultShort}}</td>
					<td>{{$d->streak}}</td>
					<td class='editabledd warning'>{{$d->type}}</td>
					<td class='editabledd warning'>{{$d->bookmakerName}}</td>
					<td class='editable warning'>{{$d->bsf}}</td>
					<td class='editable warning'>{{$d->bet}}</td>
					<td class='editable warning'>{{$d->odds}}</td>
					<td>{{$d->income}}</td>
					<td><a href="/clone/{{$d->games_id}}"> clone </a></td>
					<td><a href="/delete/{{$d->games_id}}"> delete </a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
	<script type="text/javascript">
	// $('#get_from_pool').on("click", function(){
	// 	var a = $('#amount').val();
	// 	$.post("/pools/get",
 //            {
 //                // "_token": $( this ).find( 'input[name=_token]' ).val(),
 //                "league": $(this).parent().parent().attr("id"),
 //                "game": $(this).parent().attr("id"),
 //            },
 //            function( data ) {
 //                alert(data)
 //                //do something with data/response returned by server
 //            },
 //            'json'
 //        );
	// });

	$( "tbody>tr" ).hover(
		function() {
			var claz = $(this).attr('class');
			var st = claz.split(' ');
			var firstClass = st[0];

			var id="."+firstClass;
			//alert(id);
			if ($(id).length > 1) {
				$(id+">td").addClass("text-primary");
			}
			//$(id).attr("style", "color: red");
			//$( this ).append( $( "<span> ***</span>" ) );
		}, function() {
			var claz = $(this).attr('class');
			var st = claz.split(' ');
			var firstClass = st[0];

			var id="."+firstClass;
			//alert(id);
			$(id+">td").removeClass("text-primary");
			//$(id).addClass("test");			
		}
	);

	var asInitVals = new Array();

	$(document).ready(function(){

		var oTable = $("#matches").dataTable({
	    	    "iDisplayLength": 100,
	    	    "bJQueryUI": true,
	    	    "sPaginationType": "full_numbers"
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

		/* Apply the jEditable handlers to the table */
		    oTable.$('td.editable').editable( '/save', {
	        "callback": function( sValue, y ) {
	            var aPos = oTable.fnGetPosition( this );
	            var arr = sValue.split("#");
	            oTable.fnUpdate( arr[0], aPos[0], 8 );
	           	oTable.fnUpdate( arr[1], aPos[0], 9 );
	            oTable.fnUpdate( arr[2], aPos[0], 10 );
	            oTable.fnUpdate( arr[3], aPos[0], 11 );
	            if (arr[4] != "") {
	            	if (arr[4] != $("#pool").text()) {
	            		$("#crr").html("<strong>"+arr[4]+"</strong>");
	            	} else {
	            		$("#crr").html(arr[4]);
	            	}
	            	
	            }
	        },
	        "submitdata": function ( value, settings ) {
	            return {
	                "row_id": this.parentNode.getAttribute('id'),
	                "column": oTable.fnGetPosition( this )[2]
	            };
	        },
	        "height": "25px",
	        "width": "40px"
	    } );

	    oTable.$('td.editabledd').editable( '#', {
	        "callback": function( sValue, y ) {
	            var aPos = oTable.fnGetPosition( this );
	            var arr = sValue.split("#");
	            
	            //oTable.fnUpdate( arr[0], aPos[0], 7 );
	        },
	        "submitdata": function ( value, settings ) {
	            return {
	                "row_id": this.parentNode.getAttribute('id'),
	                "column": oTable.fnGetPosition( this )[2]
	            };
	        },
	        "height": "25px",
	        "width": "40px"
	    } );

		if ($("#crr").text() != $("#pool").text()) {
    		$("#crr").html("<strong>"+$("#crr").text()+"</strong>");
    	} else {
    		$("#crr").html(arr[4]);
    	}

	});
	</script>
@stop
