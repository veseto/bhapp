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
	function parseResults($baseUrl, $alternativeUrl, $alternativeUrl2, $alternativeUrl3, $alternativeUrl4, $season, $leagueId) {
		include("../includes/connection.php");
		$workingBaseUrl = $baseUrl;
		$url = $baseUrl."results/";
		echo "$url<br>";
		$year = explode('-', $season)[0];

		if(get_http_response_code($url) != "200"){
		    $url = $alternativeUrl."results/";
		    $workingBaseUrl = $alternativeUrl;
		}
		if(get_http_response_code($url) != "200"){
		    $url = $alternativeUrl2."results/";
		    $workingBaseUrl = $alternativeUrl2;
		}
		if(get_http_response_code($url) != "200"){
		    $url = $alternativeUrl3."results/";
		    $workingBaseUrl = $alternativeUrl3;
		    $season = explode('-', $season)[0];
		}
		if(get_http_response_code($url) != "200"){
		    $url = $alternativeUrl4."results/";
		    $workingBaseUrl = $alternativeUrl4;
		    $season = explode('-', $season)[0];
		}
		if(get_http_response_code($url) != "200"){
		    return;
		}
		$mysqli->query("INSERT INTO importedSeasons (league_details_id, season) values ($leagueId, '$season')");
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
				

				$table = $dom->getElementById ('leagueresults_tbody');
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
				    	$matchId = "";
				    	$a = $cols->item(0)->getElementsByTagName('a');
				    	foreach ($a as $link) {
				    		$href = $link->getAttribute("href");
				    		$urlParts = explode("=", $href);
				    		$matchId = $urlParts[1];
				    	}
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
				    	
				    	$q0 = "INSERT INTO bhapp.match (id, season, round, league_details_id, stage) values ('$matchId', '$season', '$round', $leagueId, '$stageName')";
				    	// echo "$q0<br>";
				    	$mysqli->query($q0);
				    	
				    	echo $mysqli->error;
					}

				    // echo "<br>";
			    }
			}
		} else {
			$table = $dom->getElementById ('leagueresults_tbody');
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
			    	$matchId = "";
			    	$a = $cols->item(0)->getElementsByTagName('a');
			    	foreach ($a as $link) {
			    		$href = $link->getAttribute("href");
			    		$urlParts = explode("=", $href);
			    		$matchId = $urlParts[1];
			    	}
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
			    	
			    	$q0 = "INSERT INTO bhapp.match (id, season, round, league_details_id, stage) values ('$matchId', '$season', '$round', $leagueId, 'main')";
			    	echo "$q0<br>";
			    	$mysqli->query($q0);
			    	
			    	echo $mysqli->error;
				}

			    // echo "<br>";
		    }
		}

		

	}
?>