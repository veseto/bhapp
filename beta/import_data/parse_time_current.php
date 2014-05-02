<?php
	include("../includes/connection.php");
	// include("parsematchdetails.php");
	// $league = $mysqli->query("SELECT * FROM leagueDetails")->fetch_assoc();
	
	// $baseUrl = "http://www.betexplorer.com/soccer/poland/ekstraklasa-2010-2011/";
			//$url = "http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=USA&leagueName=ALL+STAR+GAME&seasonName=$season&sortBy=R&round=$n&result=3#.UvjQ30KSztk";

	function parseResults($matchId) {
		// include("../includes/connection.php");
		// $matchId = 'WzWbfbZh';
		$url = "http://www.betexplorer.com/soccer/poland/ekstraklasa/piast-gliwice-slask-wroclaw/$matchId/";
		$data = file_get_contents($url);

		//echo "$url<br>";

		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;
		
		$dateElement = $dom->getElementById('nm-date')->getAttribute('data-dt');

		$arr = explode(',', $dateElement);
		$time = $arr[3].':'.$arr[4].":00";
		// print_r($dateElement);
		return $time;
	}

	$res = $mysqli->query("SELECT id FROM `match` where matchTime='00:00:00' and league_details_id in (11, 12, 13, 14, 15)"); //6, 39, 35, 69, 100, 17
	while ($row = $res->fetch_array()) {
		$id = $row[0];
		$time = parseResults($id);
		$q="update `match` set matchTime='$time' where id='$id'";
		echo "$q";
		$mysqli->query($q);
	}

?>