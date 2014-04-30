
<?php

class MatchController extends BaseController {

	public function showWelcome($country, $leagueName, $season)	{
		
		return View::make('stats');
	
	}

	public function getStats($country, $leagueName, $season) {
		
		$leagueId = LeagueDetails::getId($country, $leagueName);
		
		$distResults = $this->getUniqueResults(Match::matchesForSeason($leagueId, $season));

		$allCount = Match::matchesForSeason($leagueId, $season)->count();
		$drawCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'D')->count();
		$homeCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'H')->count();
		$awayCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'A')->count();
		$seq = $this->getSequences($country, $leagueName, $season);
		$sSeq = Match::matchesForSeason($leagueId, $season)->get(array('resultShort', 'home', 'away', 'matchDate', 'matchTime', 'homeGoals', 'awayGoals'));
		

		$array = array('league' => $leagueName, 
						'country' => $country,
						'season' => $season,
						'all' => $allCount, 
						'draw' => $drawCount, 
						'home' => $homeCount,
						'away' => $awayCount,
						'distResults' => $distResults, 
						'seq' => $seq, 
						'sSeq' => $sSeq);

		//->nest('seq',  'sequences', array('sequences' => $seq)
		return View::make('stats')->with('data', $array);
	
	}

	public function getSequences($country, $leagueName, $season) {

		$seq = array();
		$leagueId = LeagueDetails::getId($country, $leagueName);
		$teams = Match::matchesForSeason($leagueId, $season)->distinct('home')->get(array('home'));
		foreach ($teams as $team) {
			$res = array();
			// $seq[$team->home] = array();
			$regexp = $team->home;
			
			$matches = Match::matchesForSeason($leagueId, $season)
            ->where(function($query) use ($regexp)
            {
                $query->where('home', '=', $regexp)
                      ->orWhere('away', '=', $regexp);
            })
			->orderBy('matchDate', 'desc')->get();
			// foreach ($matches as $match) {
			// 	if ($match->resultShort == 'D') {
			// 		array_push($res, 'D');
			// 	} else if (($team->home === $match->home and $match->resultShort == 'H') or ($team->home === $match->away and $match->resultShort == 'A')) {
			// 		array_push($res, 'W');
			// 	} else {
			// 		array_push($res, 'L');
			// 	}
			// 	// array_push($seq[$team->home], $res);
			// }
			$seq = array_add($seq, $team->home, $matches);
		}	

		return $seq;
		// return View::make('sequences')->with('sequences', $seq);
	}


	private function getUniqueResults($matches) {

		//return $results = Match::groupBy('homeGoals', 'awayGoals')->get(array('homeGoals', 'awayGoals', DB::raw('count(*) as count'));
		return $matches->select('homeGoals', 'awayGoals', DB::raw('count(*) as total'))
                 ->groupBy('homeGoals', 'awayGoals')
                 ->get();
	}

	public function getTodaysMatches(){
		// $d = date("Y-m-d", time());
		// $matches = Match::where('id', '=', '000cQmf2')->get();

		return View::make('matches');
	}



	 public function getDatatable()
    {
        return Datatable::collection(Match::where('league_details_id', '=', '1')->get(array('home','away')))
        ->showColumns('home', 'away')
        ->searchColumns('home', 'away')
        ->orderColumns('home','away')
        ->make();
    }

}
