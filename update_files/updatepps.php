<?php
include("/var/www/connection.php");
$start = time();
$updatedMatches = 0;
$updatedMatchesToPlay = 0;

$teams = array();
$season = "2013%2F2014";
$settings = $mysqli->query("SELECT leaguesRequirements from userSettings where userId=1")->fetch_array()[0];
$settings = unserialize($settings);
$cntry = '';
$lg = '';
foreach ($leagues as $country => $leagueKey) {
			$cntry = str_replace("+", " ", $country);
			$leagueName = str_replace("+", " ", $leagueKey);
			$leagueId = $mysqli->query("SELECT leagueId from leagueDetails where country='$cntry' and name='$leagueName'")->fetch_array()[0];
			$lg = $leagueName;

			$data1 = file_get_contents("http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=$country&leagueName=$leagueKey&seasonName=2013%2F2014&sortBy=R&result=3#.Us6_JvQW3zg");

			$dom1 = new domDocument;

			@$dom1->loadHTML($data1);
			$dom1->preserveWhiteSpace = false;

			$select = $dom1->getElementById ('round');
			$op = $select->getElementsByTagName('option');
			$firstRound = $select->firstChild->getAttribute('value');
			$roundCount = $select->lastChild->nodeValue;
			//echo "$country $leagueName $roundCount<br>";

			$q0 = "SELECT round 
					FROM matches 
					left join leagueDetails 
					on (leagueDetails.leagueId=matches.leagueId) 
					where country='$cntry' and name='$leagueName' and state<>'Fin' 
					order by round 
					limit 1";
			// echo "$q0<br>";
			$first = $mysqli->query($q0)->fetch_array()[0];

			for ($j = $first; $j <= $roundCount; $j ++) {
				$n = $firstRound + $j - 1;
				//$round = $j + 1;
			// 	//echo "Round ".$j."<br>";
			 	$data = file_get_contents("http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=$country&leagueName=$leagueKey&seasonName=2013%2F2014&sortBy=R&round=$n&result=3#.Us6_JvQW3zg");

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
						
						//echo "$home - $away $ft $j $stat <strong> $date </strong> <br>";
						if ($stat === 'Fin' || $stat === 'Sched' || $stat === 'Abd' || $stat === 'Post') {
							$q3 = "SELECT * 
									FROM matches 
									where season='2013-2014' and homeTeam='$home' and awayTeam='$away' and round=$j";
							// echo "$q3";
							$mres = $mysqli -> query($q3);
							$m = $mres -> fetch_assoc();

							if (($stat === 'Post' || $stat === 'Abd') && $m['state'] === 'Sched') {
								$mysqli->query("delete FROM playedMatches where matchId=".$m['matchId']);
							}
								$q1 = "UPDATE matches 
										set matchDate='$date', matchTime='$time', state='$stat', result='$ft', resultShort='$ftShort' 
										where matchId=".$m['matchId'];
								//echo $q1;
								$mysqli->query($q1);

								$d = date("Y-m-d", time() - 4*86400);
							 	if ($ftShort != '-' && $stat==='Fin' && $date > $d && $m['resultShort'] === '-') {
							 		$updatedMatches ++;
							 		// echo "$home $away: $ftShort<br>";
							 		//print_r($m);
										// print_r($c);
										// echo " ---> $home - $away $ft / $ftShort<br>";
									//$homeSeries = $mysqli->query("SELECT seriesId FROM series where team='$home' and active=1")->fetch_array()[0];
									//$awaySeries = $mysqli->query("SELECT seriesId FROM series where team='$away' and active=1")->fetch_array()[0];
									if ($ftShort === 'D') {
										 $mysqli->query("update series set active=0, length=length+1 where team='$home' or team='$away'");
										echo $mysqli->error;
										 $mysqli->query("INSERT INTO series (team, length, active, leagueId) values ('".$m['homeTeam']."', 1, 1, ".$m['leagueId'].")");
										 echo $mysqli->error;
										 $mysqli->query("INSERT INTO series (team, length, active, leagueId) values ('".$m['awayTeam']."', 1, 1, ".$m['leagueId'].")");
										 echo $mysqli->error;

									} else {
										$mysqli->query("update series set length=length+1 where (team='$home' or team='$away') and active=1");
					 					echo $mysqli->error;
									}
								}



								
							}
							
						}	
					}
				}
			}
		
		}
	

	$res = $mysqli->query("SELECT * from series where active=1 and leagueId=$leagueId");
	while ($serie = $res->fetch_assoc()) {
		$q1 = "SELECT * FROM `matches` 
				left join series on (series.team=matches.homeTeam or series.team=matches.awayTeam) 
				where matches.resultShort='-' and series.seriesId=".$serie['seriesId']." and state='Sched' order by matchDate asc limit 1;";
		$res2 = $mysqli->query($q1);
		$match = $res2->fetch_assoc();
		if ($match) {
			//echo $match['length']." > ".$settings[$match['leagueId']]."<br>";
			if ($match['length'] > $settings[$match['leagueId']]) {
				$q2="SELECT count(*) from playedMatches where matchId=".$match['matchId']." and seriesId=".$match['seriesId'];
				if ($mysqli->query($q2)->fetch_array()[0] === '0') {
					$q4="select * from matches left join (playedMatches, series) on (playedMatches.matchId=matches.matchId and series.seriesId=playedMatches.seriesId) where resultShort='-' and userId=1 and playedMatches.seriesId=".$serie['seriesId'];
					//echo "$q4<br>";
					$tmp = $mysqli->query($q4);
					if ($tmp->num_rows) {
						$old = $tmp->fetch_assoc();
						$mysqli->query("delete FROM playedMatches where matchId=".$old['matchId']);
					}				
					$updatedMatchesToPlay ++;
					for ($i = 1; $i < 4; $i ++) {
						$q5="SELECT betSoFar, bet FROM playedMatches left join matches on matches.matchId=playedMatches.matchId where userId=$i and seriesId=".$serie['seriesId']." and state='Fin' order by matchDate desc, matchTime desc limit 1";
						echo "$q5 ";
						$a = $mysqli->query($q5)->fetch_array();
						$betSoFar = $a[0] + $a[1];
						echo "    $betSoFar <br>";
						$q7="INSERT INTO playedMatches (userId, matchId, currentLength, odds, bet, ignored, seriesId, betSoFar, profit) values ($i, ".$match['matchId'].", ".$serie['length'].", 3, 0, 0, ".$match['seriesId'].", '$betSoFar', ".(0-$betSoFar).")";
						$mysqli->query($q7);
						echo $mysqli->error;
					}
				} 
			}
		} else {
	//		echo $serie['seriesId']."<br>";
		}
	}
	$sec = time() - $start;
	$mysqli->query("INSERT INTO stats (leagueId, lastSec, updated, addedToPlay) values ($leagueId, $sec, $updatedMatches, $updatedMatchesToPlay)");
	echo "ended";
	// file_put_contents("/var/www/bh/data_manage/updateStats.txt", "$cntry->$lg ".date("Y-m-d h:i:s", time())." - seconds: ".$sec."  updated matches: ".$updatedMatches."  added matches to play: ".$updatedMatchesToPlay."\n", FILE_APPEND);
?>