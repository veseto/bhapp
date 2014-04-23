<?php
	include('includes/connection.php');
	$leagueId=$_GET['league'];

	$res = $mysqli->query("SELECT matchDate, homeGoals, awayGoals, resultShort from `match` where leagueId=$leagueId order by matchDate");
	while ($row = $res->fetch_assoc()) {
		echo $row['matchDate'].';'.$row['homeGoals'].';'.$row['awayGoals'].';'.$row['resultShort'].'<br>';
	}
?>