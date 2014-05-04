<?php
	// include("includes/connection.php");
	// include("parsematchdetails.php");
	// $league = $mysqli->query("SELECT * FROM leagueDetails")->fetch_assoc();
	
	// $baseUrl = "http://www.betexplorer.com/soccer/poland/ekstraklasa-2010-2011/";
			//$url = "http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=USA&leagueName=ALL+STAR+GAME&seasonName=$season&sortBy=R&round=$n&result=3#.UvjQ30KSztk";
	function get_http_response_code($url) {
	    $headers = get_headers($url);
	    return substr($headers[0], 9, 3);
	}
	function parseFix($baseUrl, $season, $leagueId) {
		include("../includes/connection.php");
		ini_set('display_errors', 'on');
		error_reporting(-1);
		$workingBaseUrl = $baseUrl;
		$url = $baseUrl."fixtures/";
		echo "$url<br>";
		$year = explode('-', $season)[0];

		if(get_http_response_code($url) != "200"){
		    return;
		}
		// $mysqli->query("INSERT INTO importedSeasons (league_details_id, season) values ($leagueId, '$season')");
		$data = file_get_contents($url);

		//echo "$url<br>";

		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;
		
		$stagesMenu = $dom->getElementById('sm-0-0');
		if ($stagesMenu != null) {
			$as = $stagesMenu->getElementsByTagName('a');
			foreach ($as as $a) {
				$stage = $a->getAttribute('href');
				$stageName = $a->nodeValue;
				// echo "$stage $name";

				$data = file_get_contents($url.$stage);

		//echo "$url<br>";

				$dom = new domDocument;

				@$dom->loadHTML($data);
				$dom->preserveWhiteSpace = false;
				

				$table = $dom->getElementsByTagName('table')->item(0);
				
				$rows = $table->getElementsByTagName('tr');
				$round = -1;

				foreach ($rows as $row) {
					$headings = $row->getElementsByTagName('th');
					if ($headings->length > 0) {
						$round = $headings->item(0)->nodeValue;
					}
					// echo "$round<br>";

				    $cols = $row->getElementsByTagName('td');
				 //    // foreach ($cols as $col) {
				    	
				 //    // 	$attrs = $col->getAttribute("data-odd");
				 //    // 	echo $attrs." ".$col->nodeValue." ";
				 //    // }
				    if ($cols->length > 0) {
				    	if ($cols->item(0)->nodeValue == 'No matches found') break;
				    	$matchId = "";
				    	$strdate = "";
				    	$strtime = "";

				    	if (strlen($cols->item(0)->nodeValue) > 5) {
				    	$time_date = explode(' ', $cols->item(0)->nodeValue);
				    	$dateArr = explode('.', $time_date[0]);
				    	$strdate = $dateArr[2]."-".$dateArr[1]."-".$dateArr[0];
				    	$strtime = $time_date[1].":00";

				    	// echo "$strdate -> $strtime<br>";
				    	}
				    	$a = $cols->item(1)->getElementsByTagName('a');

				    	foreach ($a as $link) {
				    		$href = $link->getAttribute("href");
				    		$urlParts = explode("/", $href);
				    		$matchId = $urlParts[count($urlParts) - 2];
				    		// $matchId = $urlParts[1];
				    	}
				    	$home_away_arr = explode(" - ", $cols->item(1)->nodeValue);
				    	$home = $mysqli->escape_string($home_away_arr[0]);
				    	$away = $mysqli->escape_string($home_away_arr[1]);
				    	// $teams = explode(" - ", $cols->item(0)->nodeValue);
				    	// //print_r($teams);
				    	// if (strlen($cols->item(1)->nodeValue) > 2) {
					    // 	$goals = explode(":", $cols->item(1)->nodeValue);
					    // 	if ($goals[0] > $goals[1]) {
					    // 		$resultShort = 'H';
					    // 	} else if ($goals[0] < $goals[1]) {
					    // 		$resultShort = 'A';
					    // 	} else {
					    // 		$resultShort = 'D';
					    // 	}
					    // }
					    // $date = explode('.', $cols->item(5)->nodeValue);
					    // $dateStr = $date[2].'-'.$date[1].'-'.$date[0];
					    //echo $cols->item(6)->nodeValue;
					   // echo parseMatchDetails($workingBaseUrl, $matchId, $season, $round, $leagueId);
				    	
				    	$q0 = "INSERT INTO bhapp.match (id, season, round, league_details_id, stage, home, away, matchDate, matchTime) values ('$matchId', '$season', '$round', $leagueId, '$stageName', '$home', '$away', '$strdate', $strtime)";
				    	echo "$q0<br>";
				    	$mysqli->query($q0);
				    	if (!$mysqli->query($q0)) {
				    		$mysqli->query("Update `match` set home='$home', away='$away', stage='$stageName', matchDate='$strdate', matchTime='$strtime' where matchId='$matchId'");
				    	}
				    	// echo $mysqli->error;
					}

				    // echo "<br>";
			    }
			}
		} else {
			$table = $dom->getElementsByTagName ('table')->item(0);
			$rows = $table->getElementsByTagName('tr');
			$round = -1;

			foreach ($rows as $row) {
					$headings = $row->getElementsByTagName('th');
					if ($headings->length > 0) {
						$round = $headings->item(0)->nodeValue;
					}
					// echo "$round<br>";

				    $cols = $row->getElementsByTagName('td');
				 //    // foreach ($cols as $col) {
				    	
				 //    // 	$attrs = $col->getAttribute("data-odd");
				 //    // 	echo $attrs." ".$col->nodeValue." ";
				 //    // }
				    if ($cols->length > 0) {
				    	if ($cols->item(0)->nodeValue == 'No matches found') break;
				    	$matchId = "";
				    	$strdate = "";
				    	$strtime = "";

				    	if (strlen($cols->item(0)->nodeValue) > 5) {
				    	$time_date = explode(' ', $cols->item(0)->nodeValue);
				    	$dateArr = explode('.', $time_date[0]);
				    	$strdate = $dateArr[2]."-".$dateArr[1]."-".$dateArr[0];
				    	$strtime = $time_date[1].":00";

				    	// echo "$strdate -> $strtime<br>";
				    	}
				    	$a = $cols->item(1)->getElementsByTagName('a');

				    	foreach ($a as $link) {
				    		$href = $link->getAttribute("href");
				    		$urlParts = explode("/", $href);
				    		$matchId = $urlParts[count($urlParts) - 2];
				    		// $matchId = $urlParts[1];
				    	}
				    	$home_away_arr = explode(" - ", $cols->item(1)->nodeValue);
				    	$home = $mysqli->escape_string($home_away_arr[0]);
				    	$away = $mysqli->escape_string($home_away_arr[1]);
				    	// $teams = explode(" - ", $cols->item(0)->nodeValue);
				    	// //print_r($teams);
				    	// if (strlen($cols->item(1)->nodeValue) > 2) {
					    // 	$goals = explode(":", $cols->item(1)->nodeValue);
					    // 	if ($goals[0] > $goals[1]) {
					    // 		$resultShort = 'H';
					    // 	} else if ($goals[0] < $goals[1]) {
					    // 		$resultShort = 'A';
					    // 	} else {
					    // 		$resultShort = 'D';
					    // 	}
					    // }
					    // $date = explode('.', $cols->item(5)->nodeValue);
					    // $dateStr = $date[2].'-'.$date[1].'-'.$date[0];
					    //echo $cols->item(6)->nodeValue;
					   // echo parseMatchDetails($workingBaseUrl, $matchId, $season, $round, $leagueId);
				    	
				    	$q0 = "INSERT INTO bhapp.match (id, season, round, league_details_id, stage, home, away, matchDate, matchTime) values ('$matchId', '$season', '$round', $leagueId, 'main', '$home', '$away', '$strdate', '$strtime')";
				    	echo "$q0<br>";
				    	$mysqli->query($q0);
				    	if (!$mysqli->query($q0)) {
				    		$mysqli->query("Update `match` set home='$home', away='$away', stage='main', matchDate='$strdate', matchTime='$strtime' where matchId='$matchId'");
				    	}
				    	// echo $mysqli->error;
					}

				    // echo "<br>";
			    }
		}	

	}

?>