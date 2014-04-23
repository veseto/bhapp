<?php
	include("/var/www/connection.php");
  
  	$cntry = '';
  	$lg = '';

   	echo date("Y-m-d h:i:s", time());
   	$start=time();
   	$updatedMatches = 0;
   	$updatedMatchesToPlay = 0;
   	foreach ($league as $key => $value) {
   		$cntry = str_replace("+", " ", $key);
			$leagueName = str_replace("+", " ", $value);
			$leagueId = $mysqli->query("SELECT leagueId from leagueDetails where country='$cntry' and name='$leagueName'")->fetch_array()[0];
			echo "$leagueId<br>";
			$lg = $leagueName;

				$data1 = file_get_contents("http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=$key&leagueName=$value&leagueName1=$value&seasonName=2013%2F2014&sortBy=R&result=3#.Us6_JvQW3zg");

			$dom1 = new domDocument;

			@$dom1->loadHTML($data1);
			$dom1->preserveWhiteSpace = false;

			$select = $dom1->getElementById ('round');
			$op = $select->getElementsByTagName('option');
			$firstRound = $select->firstChild->getAttribute('value');
			$roundCount = $select->lastChild->nodeValue;
			//echo "$country $leagueName $roundCount<br>";

			
			for ($j = 0; $j <= $roundCount; $j ++) {
				$n = $firstRound + $j;
				$round = $j + 1;
			// 	//echo "Round ".$j."<br>";
			 	$data = file_get_contents("http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=$key&leagueName=$value&leagueName1=$value&seasonName=2013%2F2014&sortBy=R&round=$n&result=3#.Us6_JvQW3zg");

				$dom = new domDocument;

				@$dom->loadHTML($data);
				$dom->preserveWhiteSpace = false;
				$tables = $dom->getElementById ('scoretable');

				$rows = $tables->getElementsByTagName('tr');
				foreach ($rows as $row) {
				    $cols = $row->getElementsByTagName('td');
				    if ($cols->length == 1) {
				    	$date = $cols->item(0)->nodeValue;
				    } else {
				    	
				    	if ($cols->item(0)->nodeValue != "K/O") {
				    		//echo "$country $leagueName $date ";
						    $time = $cols->item(0)->nodeValue;
						    $stat = $cols->item(1)->nodeValue;
						    $home = $cols->item(4)->nodeValue;
						    $away = $cols->item(7)->nodeValue;
						    $ft = $cols->item(11)->nodeValue;
						    $tmp = explode("-", $ft);
						    if ($tmp[0] != "" && $tmp[1] != ""){
							    if ($tmp[0] === $tmp[1]){
							    	$ftShort = "D";
							    } else if ($tmp[0] > $tmp[1]) {
							    	$ftShort = "H";
							    } else {
							    	$ftShort = "A";
							    }
							} else {
								$ftShort = "-";
							}
						if ($stat === 'Fin' || $stat === 'Sched' || $stat === 'Abd' || $stat === 'Post') {
							$q3 = "SELECT * 
									FROM matches 
									where season='2013-2014' and homeTeam='$home' and awayTeam='$away' and round=$round";
							//echo "$q3<br>";
							$m = $mysqli -> query($q3) -> fetch_assoc();
							
							if (($stat === 'Post' || $stat === 'Abd') && $m['state'] === 'Sched') {
								$mysqli->query("delete FROM playedMatches where matchId=".$m['matchId']);
							}
								$q1 = "UPDATE matches 
										set matchDate='$date', matchTime='$time', state='$stat', result='$ft', resultShort='$ftShort' 
										where matchId=".$m['matchId'];
								//echo $q1."<br>";
								$mysqli->query($q1);

							 	if ($ftShort != '-' && $stat==='Fin' && $m['resultShort'] === '-') {
							 		$updatedMatches ++;
									$homeSeries = $mysqli->query("SELECT seriesId FROM series where team='$cntry' and active=1")->fetch_array()[0];
									if ($ftShort === 'D') {
										$mysqli->query("update series set active=0, length=length+1 where seriesId='$homeSeries'");
										echo $mysqli->error;
										$mysqli->query("INSERT INTO series (team, length, active, leagueId) values ('$cntry', 1, 1, ".$m['leagueId'].")");
										echo $mysqli->error;
									} else {
										$mysqli->query("update series set length=length+1 where seriesId='$homeSeries'");
					 					echo $mysqli->error;
									}

								}



								} 
					}
					
				}	
			}
		}
	}

	$res = $mysqli->query("SELECT * from series where active=1 and team='$cntry'");
	if ($serie = $res->fetch_assoc()) {
		$q1 = "SELECT * FROM `matches` 
				where matches.resultShort='-' and state='Sched' and leagueId=$leagueId order by matchDate asc, matchTime asc limit 1";
				//echo "$q1<br>";
		$res2 = $mysqli->query($q1);
		$match = $res2->fetch_assoc();
		if ($match) {
			//echo $match['length']." > ".$settings[$match['leagueId']]."<br>";
				//$mysqli->query("UPDATE matches set homeTeamSeriesID=".$serie['seriesId'].", awayTeamSeriesID=".$serie['seriesId']." where matchId=".$match['matchId']);	
				
				$q2="SELECT count(*) from playedMatches where matchId=".$match['matchId']." and seriesId=".$serie['seriesId'];
				if ($mysqli->query($q2)->fetch_array()[0] === '0') {
					$q4="select * from matches left join (playedMatches, series) on (playedMatches.matchId=matches.matchId and series.seriesId=playedMatches.seriesId) where resultShort='-' and userId=1 and playedMatches.seriesId=".$serie['seriesId'];
					$tmp = $mysqli->query($q4);
					if ($tmp->num_rows) {
						$old = $tmp->fetch_assoc();
						//$mysqli->query("UPDATE matches set homeTeamSeriesID=0, awayTeamSeriesID=0 where matchId=".$old['matchId']);
						$mysqli->query("delete FROM playedMatches where matchId=".$old['matchId']);
					}
					
					$updatedMatchesToPlay ++;
					for ($i = 1; $i < 4; $i ++) {
						$a = $mysqli->query("SELECT betSoFar, bet FROM playedMatches left join matches on matches.matchId=playedMatches.matchId where userId=$i and seriesId=".$serie['seriesId']." and state='Fin' order by matchDate desc, matchTime desc limit 1")->fetch_array();
						
						$betSoFar = $a[0] + $a[1];
						echo "$betSoFar <br>";
						$q7="INSERT INTO playedMatches (userId, matchId, currentLength, odds, bet, ignored, seriesId, betSoFar, pps, profit) values ($i, ".$match['matchId'].", ".$serie['length'].", 3, 0, 0, ".$serie['seriesId'].", '$betSoFar', 0, ".(0-$betSoFar).")";
						$mysqli->query($q7);
						echo $mysqli->error;
					}
				} 
		} else {
	//		echo $serie['seriesId']."<br>";
		}
		$count = $mysqli->query("SELECT COUNT(*) from playedMatches left join matches on matches.matchId=playedMatches.matchId where resultShort='-' and seriesId=".$serie['seriesId'])->fetch_array()[0];
		if ($count > 3) {
			$m2 = $mysqli->query("select * from playedMatches left join matches on matches.matchId=playedMatches.matchId where resultShort='-' and seriesId=".$serie['seriesId']." order by matchDate asc, matchTime asc limit 1")->fetch_assoc();
			echo $mysqli->error;
			$q0 = "delete playedMatches from playedMatches 
				left join matches on matches.matchId=playedMatches.matchId 
				where seriesId=".$serie['seriesId']." and resultShort='-' and matchDate>'".$m2['matchDate']."' 
				or (matchDate=".$m2['matchDate']." and matchTime>'".$m2['matchTime']."')";
				echo "$q0<br>";
			$mysqli->query($q0);
			echo $mysqli->error;
		}
	}



	$sec = time() - $start;
	$mysqli->query("INSERT INTO stats (leagueId, lastSec, updated, addedToPlay) values ($leagueId, $sec, $updatedMatches, $updatedMatchesToPlay)");
	// file_put_contents("/var/www/bh/data_manage/updateStats.txt", "$cntry->$lg ".date("Y-m-d h:i:s", time())." - seconds: ".$sec."  updated matches: ".$updatedMatches."  added matches to play: ".$updatedMatchesToPlay."\n", FILE_APPEND);
?>