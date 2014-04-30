<?php
	ini_set('display_errors', 'on');
	// $matchId="S6fNUCkL";

	function getMatchOdds($matchId) {
		include ("../includes/connection.php");
		$res = $mysqli -> query("SELECT * from bookmaker");
		$bookmakers = array();
		while ($b = $res -> fetch_assoc()) {
			$bookmakers[$b['bookmakerId']]=$b['bookmakerName'];
		}
		$url = "http://www.betexplorer.com/gres/ajax-matchodds.php?t=n&e=$matchId&b=1x2";
		$data = json_decode(file_get_contents($url))->odds;
		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;
		$table = $dom->getElementById ('sortable-1');
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
				    		echo $value." ".$odds1." ".$oddsX." ".$odds2."<br>";
				    	}
					}
				}	
			}
	    }
	}

	// echo getMatchOdds($matchId);
?>