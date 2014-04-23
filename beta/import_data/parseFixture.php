<?php
	include("includes/connection.php");
	ini_set('display_errors', 'on');

	// $league = $mysqli->query("SELECT * FROM leagueDetails")->fetch_assoc();
	
	$url = "http://www.betexplorer.com/soccer/england/premier-league/fixtures/";
			//$url = "http://www.xscores.com/soccer/Results.jsp?sport=1&countryName=USA&leagueName=ALL+STAR+GAME&seasonName=$season&sortBy=R&round=$n&result=3#.UvjQ30KSztk";
	echo "$url<br>";
	$data = file_get_contents($url);

	$dom = new domDocument;

	@$dom->loadHTML($data);
	$dom->preserveWhiteSpace = false;

	$finder = new DomXPath($dom);
	$classname="result-table";
	$nodes = $finder->query("//*[contains(@class, '$classname')]");
	$rows = $nodes->item(0)->getElementsByTagName("tr");
	foreach ($rows as $row) {
		$headings = $row->getElementsByTagName('th');
		if ($headings->length > 0) {
			echo $headings->item(0)->nodeValue."<br>";
		}
	    $cols = $row->getElementsByTagName('td');
	    foreach ($cols as $col) {
	    	$a = $col->getElementsByTagName('a');
	    	foreach ($a as $link) {
	    		$href = $link->getAttribute("href");
	    		// echo "$href ";
	    	}
	    	$attrs = $col->getAttribute("data-odd");
	    	echo $attrs." ".$col->nodeValue." ";
	    }
	    echo "<br>";
    }
?>