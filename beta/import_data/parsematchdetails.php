<?php
	include("../includes/connection.php");
	ini_set('display_errors', 'on');
	ini_set('display_errors', 1);

	$str='';
	$start = time();

	function get_http_response_code($url) {
	    $headers = get_headers($url);
	    return substr($headers[0], 9, 3);
	}

	function parseMatchDetails($baseUrl, $matchId, $season) {
		include("../includes/connection.php");
		$url = $baseUrl."matchdetails.php?matchid=".$matchId;
		echo "***  $matchId ***";
		if(get_http_response_code($url) != "200"){
			//  "Wrong match details url! --> $url";
			return;
		}
		$data = file_get_contents($url);

		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;
		$tables = $dom->getElementsByTagName('table');

		$date = $tables->item(0)->getElementsByTagName('tr')->item(0)->getElementsByTagName('th')->item(1)->nodeValue;
		$nums = explode('.', $date);
		$strdate = $nums[2]."-".$nums[1]."-".$nums[0];
		// echo "$matchId ";

		$scoreTable = $tables->item(1);
		$scoreRows = $scoreTable->getElementsByTagName('tr');
		
		$home = $scoreRows->item(0)->getElementsByTagName('th')->item(0)->nodeValue;
		$away = $scoreRows->item(0)->getElementsByTagName('th')->item(1)->nodeValue;

		$tmp = $scoreRows->item(1);
		$resultShort = '-';
		$homeGoals = 0;
		$awayGoals = 0;

		if ($tmp != null) {
			if ($tmp->getElementsByTagName('th')->length > 0) {
				$homeGoals = $tmp->getElementsByTagName('th')->item(0)->nodeValue;
				$awayGoals = $tmp->getElementsByTagName('th')->item(1)->nodeValue;
				if ($homeGoals > $awayGoals) {
					$resultShort = 'H';
				} else if ($homeGoals < $awayGoals) {
					$resultShort = 'A';
				} else {
					$resultShort = 'D';
				}
			}
			if ($tmp->getElementsByTagName('td')->length > 0) {
				$reason = $tmp->getElementsByTagName('td')->item(0)->nodeValue;
			}
		}
		$q1 = "UPDATE `match` set matchDate='$strdate', home='$home', away='$away', resultShort='$resultShort', homeGoals=$homeGoals, awayGoals=$awayGoals where id='$matchId'";

		if ($scoreRows->item(2) != null) {
			$results = $scoreRows->item(2)->getElementsByTagName('td')->item(0)->nodeValue;

			$h1 = "";
			$a1 = "";
			$h2 = "";
			$a2 = "";
			$state = '';
			if (strlen($results) > 2) {
				$results = str_replace('(', '', $results);
				$results = str_replace(')', '', $results);

				$halves = explode(', ', $results);
				if (count($halves) == 1) {
					$state = $results;
					$q1 = "UPDATE `match` set matchDate='$strdate', home='$home', away='$away', resultShort='$resultShort', homeGoals=$homeGoals, awayGoals=$awayGoals, state='$state' where id='$matchId'";
				} else {
					$ha1 = explode(':', $halves[0]);
					$h1 = $ha1[0];
					$a1 = $ha1[1];
					$ha2 = explode(':', $halves[1]);
					$h2 = $ha2[0];
					$a2 = $ha2[1];
					$q1 = "UPDATE `match` set matchDate='$strdate', home='$home', away='$away', resultShort='$resultShort', homeGoals=$homeGoals, awayGoals=$awayGoals, homeGoals1H=$h1, homeGoals2H=$h2, awayGoals1H=$a1, awayGoals2H=$a2, state='$state' where id='$matchId'";
				}
			} 
		} else {
				$q1 = "UPDATE `match` set matchDate='$strdate', home='$home', away='$away', resultShort='$resultShort', homeGoals=$homeGoals, awayGoals=$awayGoals where id='$matchId'";
		}

		// echo "$matchId $home - $away <br>$homeGoals:$awayGoals <br>$h1:$a1 $h2:$a2<br>***********************************<br>";
		// $q1 = "UPDATE `match` set home='$home', away='$away', resultShort='$resultShort', homeGoals=$homeGoals, awayGoals=$awayGoals, homeGoals1H=$h1, homeGoals2H=$h2, awayGoals1H=$a1, awayGoals2H=$a2 where matchId='$matchId'";
		// echo "$q1";
		// file_put_contents($file, $q1.";", FILE_APPEND);

		$mysqli->query($q1);
		echo $mysqli->error;

		if ($tables->length == 3) {
			$class = $tables->item(2)->parentNode->getAttribute("class");
			if ($class == 'fr') {
				processGoals($tables->item(2), "away", $matchId);
			} else if ($class = 'fl') {
				processGoals($tables->item(2), "home", $matchId);
			}
		}
		if ($tables->length == 4) {
			$class = $tables->item(2)->parentNode->getAttribute("class");
			if ($class == 'fr') {
				processGoals($tables->item(2), "away", $matchId);
				processGoals($tables->item(3), "home", $matchId);
			} else if ($class = 'fl') {
				processGoals($tables->item(2), "home", $matchId);
				processGoals($tables->item(3), "away", $matchId);
			}
		}  

		//echo getMatchOdds($matchId);
	}
	function processGoals($table, $team, $matchId) {
		include("../includes/connection.php");
		$rows = $table->getElementsByTagName("tr");
		foreach ($rows as $row) {
			$minute = 0;
			$cols = $row->getElementsByTagName('td');
			$player = mysql_real_escape_string($row->getElementsByTagName('th')->item(0)->nodeValue);			
			if ($team == 'home') {
				$reason = $cols->item(0)->nodeValue;
				$minute = str_replace('.', "", $cols->item(1)->nodeValue);
				//$player = $cols->item(2)->nodeValue;
		 	} else {
		 		$reason = $cols->item(1)->nodeValue;
				$minute = str_replace('.', "", $cols->item(0)->nodeValue);
				//$player = $cols->item(1)->nodeValue;
		 	}
		 	if (trim($minute) == '') {
		 		$minute = 0;
		 	}
		 	$q3 = "SELECT count(*) from goals where match_id='$matchId' and minute=$minute and player='$player'";
		 	echo "$q3<br>";
		 	$count = $mysqli->query($q3)->fetch_array()[0];
		 	if ($count < 1) {
			 	$q2 = "insert into goals (match_id, reason, minute, player) values ('$matchId', '$reason', $minute, '$player')";
			 		// file_put_contents($file, $q2.";", FILE_APPEND);

			 	$mysqli->query($q2);
			 	// return "$reason $minute $player <br>";	
			 }// } else {
			 // 	return "**********inserted**********<br>";
			 // }

		}
	}


	function getMatchOdds($matchId) {
		$odds = "";
		include ("../includes/connection.php");
		$res = $mysqli -> query("SELECT * from bookmaker");
		$bookmakers = array();
		while ($b = $res -> fetch_assoc()) {
			$bookmakers[$b['id']]=$b['bookmakerName'];
		}
		$url = "http://www.betexplorer.com/gres/ajax-matchodds.php?t=n&e=$matchId&b=1x2";
		$data = json_decode(file_get_contents($url))->odds;
		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;
		$table = $dom->getElementById ('sortable-1');
		if ($table != null) {
			$rows = $table->getElementsByTagName('tr');
			for ($i = 0; $i < $rows->length; $i ++){
				$row = $rows->item($i);
				$cols = $row->getElementsByTagName('td');
			    if ($cols->length > 3) {
				    $odds1 = $cols->item(1)->getAttribute("data-odd");
				    $oddsX = $cols->item(2)->getAttribute("data-odd");
				    $odds2 = $cols->item(3)->getAttribute("data-odd");
				   // $odds3 = $cols->item(3)->getAttribute("data-odd");
					$h = $row->getElementsByTagName('th');
					foreach ($h as $h1) {
						foreach ($bookmakers as $key => $value) {
						 	// echo $b[0]." ".$h1->nodeValue;
					    	if (strpos($h1->nodeValue, $value)) {
					    		$q3 = "SELECT count(*) from odds1x2 where match_id='$matchId' and bookmaker_id=$key";
							 	// echo "$q3<br>";
							 	$count = $mysqli->query($q3)->fetch_array()[0];
							 	if ($count < 1) {
						    		$q0 = "INSERT INTO odds1x2 (bookmaker_id, match_id, odds1, oddsX, odds2) values ($key, '$matchId', '$odds1', '$oddsX', '$odds2')";
						    		$mysqli->query($q0);
						    			// file_put_contents($file, $q0.";", FILE_APPEND);

						    		$odds = $q0."<br>";
						    	}
					    	}
						}
					}	
				}
		    }
		}
	    return $odds;
	}
	$baseUrl = "http://www.betexplorer.com/soccer/";//poland/ekstraklasa-2010-2011/";
	// $matchId = "hrhPTNlp";
	$start = time();
	//$q = "SELECT * from `match` left join leagueDetails on leagueDetails.leagueId=`match`.leagueId where leagueDetails.leagueId=4";
	// echo "$q<br>";
	$q = "SELECT `match`.id, country, fullName, season, alternativeName, alternativeName2 FROM `match` left join leagueDetails on leagueDetails.id=`match`.league_details_id where league_details_id=".$_GET['id'];
	$res = $mysqli->query($q);
	// echo $mysqli->error;
	while ($row = $res->fetch_assoc()) {
		$url = $baseUrl.$row['country'].'/'.$row['fullName'].'/';
				// echo "$url";

		if(get_http_response_code($url) != "200"){
			$url = $baseUrl.$row['country'].'/'.$row['alternativeName'].'/';
		}
		if(get_http_response_code($url) != "200"){
			$url = $baseUrl.$row['country'].'/'.$row['alternativeName2'].'/';
		}
		if(get_http_response_code($url) != "200"){
			// echo "boo";
			return;
		}
		getMatchOdds($row['id']);
		// parseMatchDetails($url, $row['id'], $row['season']);
	}
	$end = time();


	echo ($end - $start)." sec for 200 matches";

?>