<?php
	include("connection.php");
	session_start();
	if (isset($_GET['team']) && isset($_GET['series'])) {
		$t = $_GET['team'];
		$count = $mysqli->query("SELECT COUNT(*) FROM hotTeams where team='$t'")->fetch_array()[0];
		if ($count > 0) {
			$q = "delete from hotTeams where team='$t' and userId=".$_SESSION['uid'];
			echo "$q<br>";
			$mysqli->query($q);
		} else {
			$mysqli->query("insert into hotTeams (team, userId) values ('$t', ".$_SESSION['uid'].")");
		}
		header("Location: seriesdetails.php?series=".$_GET['series']);
	}
?>