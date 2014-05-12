<?php
	include('/includes/connection.php');

	$res = $mysqli->query("SELECT matchDate, matchTime FROM `match` where league_details_id=112 and season = '2013-2014' ");
	echo $mysqli->error;

	while($row = $res->fetch_assoc()) {
		// $date = date_create($row('matchDate'));
		// echo date_format($date, 'l')." ".$row('matchTime');
		echo $row('matchDate')." ".$row('matchTime');
	}
	
?>