
<?php

class MatchController extends BaseController {

	public function showWelcome($country, $leagueName, $season)	{
		
		return View::make('stats');
	
	}

	public function getStats($country, $leagueName, $season) {
		
		$leagueId = LeagueDetails::getId($country, $leagueName);
		
		$distResults = $this->getUniqueResults($leagueId, $season);

		$allCount = Match::matchesForSeason($leagueId, $season)->count();
		$drawCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'D')->count();
		$homeCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'H')->count();
		$awayCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'A')->count();
		$seq = $this->getSequences($country, $leagueName, $season);
		$sSeq = Match::matchesForSeason($leagueId, $season)->get(array('resultShort', 'home', 'away', 'matchDate', 'matchTime', 'homeGoals', 'awayGoals'));
		$pps1x2 = SeriesController::getSeriesForMatches($leagueId, $season, 1);
		$pps00 = SeriesController::getSeriesForMatches($leagueId, $season, 2);
		$pps11 = SeriesController::getSeriesForMatches($leagueId, $season, 3);
		$pps22 = SeriesController::getSeriesForMatches($leagueId, $season, 4);
		$homeGoals = Match::matchesForSeason($leagueId, $season)->sum('homeGoals');
		$awayGoals = Match::matchesForSeason($leagueId, $season)->sum('awayGoals');
		$goals = $homeGoals + $awayGoals;

		$array = array('league' => $leagueName, 
						'country' => $country,
						'season' => $season,
						'all' => $allCount, 
						'draw' => $drawCount, 
						'home' => $homeCount,
						'away' => $awayCount,
						'distResults' => $distResults, 
						'seq' => $seq, 
						'sSeq' => $sSeq, 
						'pps1x2' => $pps1x2,
						'pps00' => $pps00,
						'pps11' => $pps11,
						'pps22' => $pps22,
						'goals' => $goals,
						'homeGoals' => $homeGoals,
						'awayGoals' => $awayGoals);

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


	private function getUniqueResults($leagueId, $season) {

		//return $results = Match::groupBy('homeGoals', 'awayGoals')->get(array('homeGoals', 'awayGoals', DB::raw('count(*) as count'));
		return Match::where('league_details_id', '=', $leagueId)->where('season', '=', $season)->select('homeGoals', 'awayGoals', DB::raw('count(*) as total'))
                 ->groupBy('homeGoals', 'awayGoals')->orderBy('homeGoals', 'ASC')->orderBy('awayGoals', 'ASC')
                 ->get();
	}

	public function getTodaysMatches(){
		// $d = date("Y-m-d", time());
		// $matches = Match::where('id', '=', '000cQmf2')->get();

		return View::make('matches');
	}


		public function getTodaysMatches2(){
		// $d = date("Y-m-d", time());
		// $matches = Match::where('id', '=', '000cQmf2')->get();

		return View::make('matches2');
	}


	 public function getDatatable()
    {
    	$date = date('Y-m-d', time());
        return Datatable::collection(Match::where('league_details_id', '=', '1')->orderBy('matchTime')->get(array('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals')))
        ->showColumns('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals')
        ->searchColumns('home', 'away')
        ->orderColumns('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals')
        ->make();
    }

    public function getDatatable2()
    {
    	$date = date('Y-m-d', time());
    	$col = Match::where('league_details_id', '=', '1')->orderBy('matchTime')->get(array('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals'));
        return Datatable::collection($col)
        ->showColumns('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals')
        ->searchColumns('home', 'away')
        ->orderColumns('matchDate', 'matchTime', 'home', 'away', 'homeGoals', 'awayGoals')
        ->make();
    }
}
