<?php
	include("../includes/connection.php");
	//include("parseResults.php");
	
	ini_set('display_errors', 'on');
	error_reporting(-1);
	
	$start = time();

	$baseUrl="http://www.betexplorer.com/soccer/";
	$res = $mysqli->query("SELECT * FROM leagueDetails where id = 1");
	$leagues = array();
	while ($row = $res->fetch_assoc()) {
		array_push($leagues, $row);
	}
	print_r($leagues);
	$i = 0;
	foreach ($leagues as $league) {
		$i ++;
		for ($i = 2013; $i < 2014; $i ++) {
			$j = $i + 1;
			$season = $i."-".$j;
			//$q="SELECT COUNT(*) FROM importedSeasons WHERE (season='$season' OR season='$i') AND league_details_id=".$league['id'];
			// echo "$q<br>";
			$count = 0;
			echo $mysqli->error;
			if ($count == 0 || $count == '0') {
				$url = $baseUrl.$league['country']."/".$league['fullName']."-".$season."/";
				$alternativeUrl = $baseUrl.$league['country']."/".$league['alternativeName']."-".$season."/";
				$alternativeUrl2 = $baseUrl.$league['country']."/".$league['alternativeName2']."-".$season."/";
				$alternativeUrl3 = $baseUrl.$league['country']."/".$league['fullName']."-".$i."/";
				$alternativeUrl4 = $baseUrl.$league['country']."/".$league['alternativeName']."-".$i."/";
				echo "$alternativeUrl2 <br> $alternativeUrl3<br> $alternativeUrl4<br>";
				// echo "$url, $alternativeUrl, $season, ".$league['leagueId'];
				parseResults($url, $alternativeUrl, $alternativeUrl2, $alternativeUrl3, $alternativeUrl4, $season, $league['id']);
			}
		}
	}
	$end = time();
	echo "time elapsed for $i league(s): ".($end - $start)." sec<br>";
?>