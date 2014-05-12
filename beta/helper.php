<?php
	$round = 1;
	$dates = array('2003-04-05', '2003-04-12', '2003-04-13', '2003-04-19', '2003-04-26');
	$mid = false;
	foreach ($dates as $date) {
		$wd = date('l', strtotime( $date )); 
		// echo $wd." round $round";
		if (!$mid && ($wd == 'Tuesday' || $wd == 'Tuesday' || $wd == 'Wednesday' || $wd == 'Thursday')) {
			$round ++;
			$mid = true;
		} 
		if ($mid && ($wd == 'Friday' || $wd == 'Saturday' || $wd == 'Sunday' || $wd == 'Monday')){
			$round ++;
			$mid = false;
		}
		echo $wd." $round round<br>";
	}

?>