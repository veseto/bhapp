@extends('layout')

@section('breadcrumbs')
	<?php
		$list = array('home' => URL::to("home"));
		$active = 'settings';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => false, 'big' => "Settings"))
@stop

@section('content')
<!-- tabbed nav -->
<ul class="nav nav-tabs" id="myTab" style="border: none;">
  <li class='active'><a href="#myppsleagues">My PPS Leagues</a></li>
  <li><a href="#myppmleagues">My PPM Leagues</a></li>
  <li><a href="#mybookmakers">My Bookmakers</a></li>
  <li><a href="#personal">Personal</a></li>
</ul>

<div id='content' class="tab-content">
	<!-- tab::myleagues -->
	<div class="tab-pane active" id="myppsleagues">
		<?php $i = 0; ?>
			@foreach($settings as $country=>$leagues)
				@if($i % 2 == 0)
					<div class="row">
				@endif
				<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#{{ $country }}">
				          {{ $country }}
				        </a>
				      </h4>
					    </div>
					    <div id="{{ $country }}" class="panel-collapse collapse">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	
							  </td>
							  <td>
							  	<abbr title="Enables leagues series in the play per series mode at the specified legnth">Series</abbr> / <abbr title="Number of matches before a series becomes active. Example: If Liverpool has not made a draw for 3 matches in a row and length is set to 3 the next Liverpool match will be actie.">Length</abbr>
							  </td>
							  <td>
							  	0:0 / Length
							  </td>
							  <td>
							  	1:1 / Length
							  </td>
							  <td>
							  	2:2 / Length
							  </td>
							</tr>
							  @foreach($leagues as $name=>$s)
							<tr id="{{$s[0]}}">
							  <td>
							  	{{ $name }}
							  </td>
							  @for($j = 1; $j < 5; $j ++)
								  <td id="{{$j}}">
								  		@if($s[$j] != NULL && $s[$j]->ignore != 1)
					  			  	      	<input class="ch" type="checkbox" checked> at <input class="min_start" type="text" style="height: 20px;width: 25px;" value="{{ $s[$j]->min_start }}">
					  			  	    @else 
					  			  	      	<input class="ch" type="checkbox"> at <input class="min_start" type="text" style="height: 20px;width: 25px;" value="0" disabled>
					  			  	    @endif
								  </td>
							  @endfor
							</tr>
							
							@endforeach
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
			@if($i % 2 == 1)
					</div>
			@endif
			<?php $i ++; ?>
			@endforeach
	</div>
	<!-- tab::myppmleagues -->
	<div class="tab-pane" id="myppmleagues">
		<div class="row">
			<div class="col-xs-12 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePPM">
				          PPM
				        </a>
				      </h4>
					    </div>
					    <div id="collapsePPM" class="panel-collapse collapse in">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	
							  </td>
							  <td>
							  	Series / Length
							  </td>
							  <td>
							  	0:0 / Length
							  </td>
							  <td>
							  	1:1 / Length
							  </td>
							  <td>
							  	2:2 / Length
							  </td>
							</tr>
							<tr>
							  <td>
							  	Poland
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Australia
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Lithuania
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Spain
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Croatia
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Denmark
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
							<tr>
							  <td>
							  	Russia
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							</tr>
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
		</div>
	</div>
	<!-- tab::mybookmakers -->
	<div class="tab-pane" id="mybookmakers">
		<table class="table table-condensed">
			<tr>
			  <td style="padding-top: 15px; width: 200px;">
				<abbr title="Used as the default to calculate profit and income.">Primary Bookmaker</abbr>
			  </td>
			  <td>
				<select class="form-control" style="width: 200px;">
				  <option>bet365</option>
				  <option>betfair</option>
				  <option>bwin</option>
				  <option>unibet</option>
				  <option>pinnacle sport</option>
				</select>
			  </td>
			</tr>
			<tr>
			  <td style="padding-top: 15px;">
				<abbr title="Which odds to be displayed on the main view.">Display Odds</abbr>
			  </td>
			  <td>
				<div class="btn-group">
				<button type="button" class="btn btn-default" data-toggle="button">bet365</button>
				<button type="button" class="btn btn-default" data-toggle="button">betfair</button>
				<button type="button" class="btn btn-default" data-toggle="button">bwin</button>
				<button type="button" class="btn btn-default" data-toggle="button">unibet</button>
				<button type="button" class="btn btn-default" data-toggle="button">pinnacle sport</button>
				</div>
			  </td>
			</tr>
		</table>
	</div>
	<!-- tab::personal -->
	<div class="tab-pane" id="personal">
		<table class="table table-bordered">
			<tr>
			  <td>
			  	Current Password
			  </td>
			  <td>
			  	<input type="password">
			  </td>
			</tr>
			<tr>
			  <td>
			  	New Password
			  </td>
			  <td>
			  	<input type="password">
			  </td>
			</tr>
			<tr>
			  <td>
			  	Repeat New Password
			  </td>
			  <td>
			  	<input type="password">
			  </td>
			</tr>
		</table>
	</div>
</div>
<!-- js for tabs -->
<script type="text/javascript">
	$(".ch").change(function(){
		if (this.checked) {
			// alert("boo");
			$(this).siblings("input").removeAttr("disabled");
			// var url = "/settings/"+$(this).parent().parent().attr("id")+"/"+$(this).parent().attr("id")+"/"+$(this).siblings("input").val()+"/enable";
			// alert(url);
			$.post("/settings/enable",
	            {
	                "league": $(this).parent().parent().attr("id"),
	                "game": $(this).parent().attr("id"),
	                "min": $(this).siblings("input").val()
	            },
	            function( data ) {
	                //do something with data/response returned by server
	            },
	            'json'
	        );
		} else {
			$.post("/settings/disable",
	            {
	                // "_token": $( this ).find( 'input[name=_token]' ).val(),
	                "league": $(this).parent().parent().attr("id"),
	                "game": $(this).parent().attr("id"),
	            },
	            function( data ) {
	                //do something with data/response returned by server
	            },
	            'json'
	        );
		};               
	});
	$(".min_start").focusout(function(){
		// alert($(this).val());
	})
  $('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
</script>
@stop