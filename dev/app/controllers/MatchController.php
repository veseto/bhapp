
<?php

class MatchController extends BaseController {

	public function showWelcome($country, $leagueName, $season)	{
		
		return View::make('stats');
	
	}

	public function getStats($country, $leagueName, $season) {
		
		$league = LeagueDetails::where('country', '=', $country)->where('fullName', '=', $leagueName)->first();
		
		$distResults = $this->getUniqueResults($league->id, $season);

		$allCount = Match::matchesForSeason($league->id, $season)->count();
		$drawCount = Match::matchesForSeason($league->id, $season)->where('resultShort', '=', 'D')->count();
		$homeCount = Match::matchesForSeason($league->id, $season)->where('resultShort', '=', 'H')->count();
		$awayCount = Match::matchesForSeason($league->id, $season)->where('resultShort', '=', 'A')->count();
		$seq = $this->getSequences($country, $leagueName, $season);
		$sSeq = Match::matchesForSeason($league->id, $season)->get(array('resultShort', 'home', 'away', 'matchDate', 'matchTime', 'homeGoals', 'awayGoals'));
		$pps1x2 = SeriesController::getSeriesForMatches($league->id, $season, 1);
		$pps00 = SeriesController::getSeriesForMatches($league->id, $season, 2);
		$pps11 = SeriesController::getSeriesForMatches($league->id, $season, 3);
		$pps22 = SeriesController::getSeriesForMatches($league->id, $season, 4);
		$homeGoals = Match::matchesForSeason($league->id, $season)->sum('homeGoals');
		$awayGoals = Match::matchesForSeason($league->id, $season)->sum('awayGoals');
		$goals = $homeGoals + $awayGoals;
		$over = '??';//Match::matchesForSeason($leagueId, $season)->where('homeGoals + awayGoals', '>', 2.5)->count();
		$under = '??';//Match::matchesForSeason($leagueId, $season)->where('homeGoals + awayGoals', '<', 2.5)->count();
		
		$count = Match::where('league_details_id', '=', $league->id)->where('season', '=', $season)->groupBy('home')->count();
		$count = $count * 2;

		$array = array('count' => $count,
						'league' => $leagueName, 
						'ppm' => $league->ppm, 
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
						'awayGoals' => $awayGoals,
						'over' => $over,
						'under' => $under);

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

	public function getTodaysMatches($from = '2014-05-05', $to = '2014-05-05'){

	 	// $settings = Settings::where('user_id', '=', Auth::user()->id)->get();
	 	// $ids = array();
	 	// foreach ($settings as $setting) {
	 	// 	//->
	 	// 	$ids = Series::where('active', '=', 1)
			// 	->where('game_type_id', '=', $setting->game_type_id)
			// 	->where('league_details_id', '=', $setting->league_details_id)
			// 	->where('current_length', '>', $setting->min_start)
	 	// 		->lists('end_match_id');
	 	// }

        // $res = Match::join('series', 'series.end_match_id', '=', 'match.id')
	        // ->join('game_type', 'series.game_type_id', '=', 'game_type.id')
	        // ->whereIn('match.id', $ids)
	        // ->where('matchDate', '>=', $from)
	        // ->where('matchDate', '<=', $to)
	        // ->get();

	 	$res = Match::whereIn('league_details_id', array(7))->where('matchDate', '>', '2014-04-05')->get();
		return View::make('home')->with(array('data' => $res));
	}

	public function getMatches($from = "", $to = "") {

		// if ($from == "-"){
		// 	$date = new DateTime();
		// 	$from = $date->format('Y-m-d');
		// 	$to = $from;
		// }

		// $settings = Settings::where('user_id', '=', Auth::user()->id)->where('ignore', '=', 0)->get();
		// //$tmp = $ids;
	 // 	$ids = array();
	 // 	foreach ($settings as $setting) {
	 // 		//->
	 // 		$ids = array_merge($ids, DB::table('series')->where('active', '=', 1)
		// 		->where('game_type_id', '=', $setting->game_type_id)
		// 		->where('league_details_id', '=', $setting->league_details_id)
		// 		->where('current_length', '>', $setting->min_start)//->get();
	 // 			->lists('end_match_id'));
	 // 	}

        $res = Match::join('played', 'played.match_id', '=', 'match.id')
        	->join('game_type', 'game_type.id', '=', 'played.game_type_id')
	        //->join('game_type', 'series.game_type_id', '=', 'game_type.id')
	        //->whereIn('match.id', $ids)
	        ->where('user_id', '=', Auth::user()->id)
	       // ->where('matchDate', '>=', $from)
	        //->where('matchDate', '<=', $to)
	        ->get(); 

		return View::make('matches')->with(array('data' => $res));
	}

}
