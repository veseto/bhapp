<?php

class Parser {

	public static function hello() {
		return "hello";
	}

	public static function parseMatchesForGroup($group) {
		$baseUrl = "http://www.betexplorer.com/soccer/";
		$tail = "fixtures/";

		$league = LeagueDetails::findOrFail($group->league_details_id);
		$url = $baseUrl.$league->country."/".$league->fullName."/".$tail;

		if(Parser::get_http_response_code($url) != "200"){
			return "Wrong match details url! --> $url";
		}
		$data = file_get_contents($url);

		$dom = new domDocument;

		@$dom->loadHTML($data);
		$dom->preserveWhiteSpace = false;

		$finder = new DomXPath($dom);
        $classname="result-table";
        $nodes = $finder->query("//*[contains(@class, '$classname')]");
        $rows = $nodes->item(0)->getElementsByTagName("tr");
        $time = "";
        $date = "";
        $home = "";
        $away = "";
        $id = "";
        foreach ($rows as $row) {

            $headings = $row->getElementsByTagName('th');
            if ($headings->length > 0) {
                if ($headings->item(0)->nodeValue == ($group->round + 1).'. Round') {
                	break 1;
                }
            }
            $cols = $row->getElementsByTagName('td');
            if ($cols->length > 0) {
                $a = $cols->item(1)->getElementsByTagName('a');
                foreach ($a as $link) {
                    $href = $link->getAttribute("href");
                    $arr = explode("/", $href);
                    $id = $arr[count($arr) - 2];
                }
                if (strlen($cols->item(0)->nodeValue) > 3) {
                	$tmp = explode(" ", $cols->item(0)->nodeValue);
                	$time = $tmp[1].":00";
                	$datetmp = explode(".", $tmp[0]);
                	$date = $datetmp[2]."-".$datetmp[1]."-".$datetmp[0];
                }
                if (strlen($cols->item(1)->nodeValue) > 0) {
                	$home = explode(' - ', $cols->item(1)->nodeValue)[0];
                	$away = explode(' - ', $cols->item(1)->nodeValue)[1];
                }
                //$attrs = $col->getAttribute("data-odd");
                $match = Match::firstOrNew(array('id' => $id));
                $match->home = $home;
                $match->away = $away;
                $match->matchTime = $time;
                $match->matchDate = $date;
                $match->groups_id = $group->id;
                $match->save();

                // $match
            }
    	}
    }

	private static function get_http_response_code($url) {
	    $headers = get_headers($url);
	    return substr($headers[0], 9, 3);
	}

}

?>