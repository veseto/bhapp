<?php
	include("../includes/connection.php");
	include("parseresults_current.php");
	// include("parse_fixtures_ids.php");

	ini_set('display_errors', 'on');
	error_reporting(-1);
	
	$start = time();
	$baseUrl="http://www.betexplorer.com/soccer/";
	$res = $mysqli->query("SELECT * FROM leagueDetails where id=8");
	$leagues = array();
	while ($row = $res->fetch_assoc()) {
		array_push($leagues, $row);
	}
	// print_r($leagues);
	foreach ($leagues as $league) {
		$season = "2013-2014";
		// $q="SELECT COUNT(*) FROM importedSeasons WHERE (season='$season' OR season='$i') AND league_details_id=".$league['id'];
		// // echo "$q<br>";
		// $count = $mysqli->query($q)->fetch_array()[0];
		// echo $mysqli->error;
		// if ($count == 0 || $count == '0') {
		$url = $baseUrl.$league['country']."/".$league['fullName']."/";
		$alternativeUrl = $baseUrl.$league['country']."/".$league['alternativeName']."/";
		$alternativeUrl2 = $baseUrl.$league['country']."/".$league['alternativeName2']."/";
		$alternativeUrl3 = $baseUrl.$league['country']."/".$league['fullName']."/";
		$alternativeUrl4 = $baseUrl.$league['country']."/".$league['alternativeName']."/";
		// echo "$url<br>$alternativeUrl2 <br> $alternativeUrl3<br> $alternativeUrl4<br>";
		// echo "$url, $alternativeUrl, $season, ".$league['leagueId'];
		echo parseResults($url, $alternativeUrl, $alternativeUrl2, $alternativeUrl3, $alternativeUrl4, $season, $league['id']);
		// echo parseFix($url, $season, $league['id']);
	// }
	}
	$end = time();
	echo "time elapsed : ".($end - $start)." sec<br>";
?>