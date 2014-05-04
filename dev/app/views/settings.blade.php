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
		<div class="row">
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-primary">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFrance">
				          France
				        </a>
				      </h4>
					    </div>
					    <div id="collapseFrance" class="panel-collapse collapse in">
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
							<tr>
							  <td>
							  	Premiership
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
							  	Championship
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
							  	League 1
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
							  	League2
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
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseEngland">
				          England
				        </a>
				      </h4>
					    </div>
					    <div id="collapseEngland" class="panel-collapse collapse in">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	League
							  </td>
							  <td>
							  	PPS / Length
							  </td>
							  <td>
								PPM
							  </td>
							</tr>
							<tr>
							  <td>
							  	Premiership
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	Championship
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League 1
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League2
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseGermany">
				          Germany
				        </a>
				      </h4>
					    </div>
					    <div id="collapseGermany" class="panel-collapse collapse">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	League
							  </td>
							  <td>
							  	PPS / Length
							  </td>
							  <td>
								PPM
							  </td>
							</tr>
							<tr>
							  <td>
							  	Premiership
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	Championship
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League 1
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League2
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseItaly">
				          Italy
				        </a>
				      </h4>
					    </div>
					    <div id="collapseItaly" class="panel-collapse collapse">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	League
							  </td>
							  <td>
							  	PPS / Length
							  </td>
							  <td>
								PPM
							  </td>
							</tr>
							<tr>
							  <td>
							  	Premiership
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	Championship
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League 1
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League2
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapsePoland">
				          Poland
				        </a>
				      </h4>
					    </div>
					    <div id="collapsePoland" class="panel-collapse collapse">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	League
							  </td>
							  <td>
							  	PPS / Length
							  </td>
							  <td>
								PPM
							  </td>
							</tr>
							<tr>
							  <td>
							  	Premiership
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	Championship
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League 1
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League2
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
						</table>						
				      </div>
					    </div>
			    	</div>
		    	</div>
			</div>
			<div class="col-xs-6 noPadding">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
					    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSpain">
				          Spain
				        </a>
				      </h4>
					    </div>
					    <div id="collapseSpain" class="panel-collapse collapse">
				      <div class="panel-body">
						<table class="table">
							<tr>
							  <td>
							  	League
							  </td>
							  <td>
							  	PPS / Length
							  </td>
							  <td>
								PPM
							  </td>
							</tr>
							<tr>
							  <td>
							  	Premiership
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	Championship
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League 1
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
							  </td>
							</tr>
							<tr>
							  <td>
							  	League2
							  </td>
							  <td>
			  			  	      <input type="checkbox"> at <input type="text" style="height: 20px;width: 25px;"> 
							  </td>
							  <td>
			  			  	      <input type="checkbox">
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
  $('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
</script>
@stop