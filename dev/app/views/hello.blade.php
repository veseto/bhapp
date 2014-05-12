@extends('layout')

@section('breadcrumbs')
	<!-- breadcrumbs -->
	<?php
		$list = array('Home' => URL::to("home"));
		$active = 'hello';
		$elements = array('active' => $active, 'list' => $list);
	?>
	@include('layouts.partials.breadcrumbs', array('elements' => $elements))
@stop

@section('pageHeader')
	@include('layouts.partials.pageheader', array('calendar' => true, 'big' => "Hello page", 'small' => ''))
@stop

@section('content')
    
	@foreach($data as $match)
		<?php
			$date = $match->matchDate;
			// echo $date->format('l');
			$round = 1;
			$mid = false;
			$wd = date('l', strtotime( $date )); 
			// echo $wd." round $round";
			if (!$mid && ($wd == 'Tuesday' || $wd == 'Tuesday' || $wd == 'Wednesday' || $wd == 'Thursday')) {
				$round += 1;
				$mid = true;
			} 
			if ($mid && ($wd == 'Friday' || $wd == 'Saturday' || $wd == 'Sunday' || $wd == 'Monday')){
				$round += 1;
				$mid = false;
			}
			echo $wd." $round round<br>";
		?>
		  {{$match->matchTime}} <br>
	@endforeach

@stop
