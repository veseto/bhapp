
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

		return View::make('stats')->with('data', $array);
	
	}

	public function getSequences($country, $leagueName, $season) {

		$seq = array();
		$leagueId = LeagueDetails::getId($country, $leagueName);
		$teams = Match::matchesForSeason($leagueId, $season)->distinct('home')->get(array('home'));
		foreach ($teams as $team) {
			$res = array();
			$regexp = $team->home;
			
			$matches = Match::matchesForSeason($leagueId, $season)
            ->where(function($query) use ($regexp)
            {
                $query->where('home', '=', $regexp)
                      ->orWhere('away', '=', $regexp);
            })
			->orderBy('matchDate', 'desc')->get();
			
			$seq = array_add($seq, $team->home, $matches);
		}	

		return $seq;
	}


	private function getUniqueResults($leagueId, $season) {

		return Match::where('league_details_id', '=', $leagueId)->where('season', '=', $season)->select('homeGoals', 'awayGoals', DB::raw('count(*) as total'))
                 ->groupBy('homeGoals', 'awayGoals')->orderBy('homeGoals', 'ASC')->orderBy('awayGoals', 'ASC')
                 ->get();
	}

	public function getTodaysMatches($from = '2014-05-05', $to = '2014-05-05'){

	 	$res = Match::whereIn('league_details_id', array(7))->where('matchDate', '>', '2014-04-05')->get();
	 	
		return View::make('home')->with(array('data' => $res));
	}

	public function getMatches($from = "", $to = "") {

        $res = Match::join('played', 'played.match_id', '=', 'match.id')
        	->join('game_type', 'game_type.id', '=', 'played.game_type_id')
        	->join('settings', 'settings.id', '=', 'played.settings_id')
        	->join('leagueDetails', 'leagueDetails.id', '=', 'settings.league_details_id')
	        ->where('user_id', '=', Auth::user()->id)
	        ->where('ignore', '=', 0)
	        ->get(); 

		return View::make('matches')->with(array('data' => $res));
	}

	public function getSimMatches($season = "2011-2012", $round = 1) {

        $res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $round.'. Round')
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home')
	        ->get(); 

		return View::make('bsim')->with(array('data' => $res, 'round' => $round, 'season' => $season, 'count' => 0, 'income' => 0, 'profit' => 0, 'multiply' => 0, 'init' => 0, 'inarr' => '', 'prarr' => ''));
	}	


	public function getSimMatches2($season = "2011-2012", $round = 1) {

        $res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $round.'. Round')
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home')
	        ->get(); 

		return View::make('sim')->with(array('data' => $res, 'round' => $round, 'season' => $season, 'count' => 0, 'income' => 0, 'profit' => 0, 'multiply' => 0, 'init' => 0, 'inarr' => '', 'prarr' => ''));
	}



	public function startSim() {
		$seasons = array("2011-2012","2012-2013","2013-2014");

		$teams = Match::distinct('home')->where('league_details_id', '=', 47)->whereIn('season', $seasons)->lists('home');

		$rounds = 38; 
		foreach ($teams as $team) {
			$count = 0;
			foreach ($seasons as $season) {
				for($i = 1; $i <= $rounds; $i ++) {

					$matches = Match::where(function($query) use ($team)
			        {
			            $query->where('home', '=', $team)
			                  ->orWhere('away', '=', $team);
			        })
			        ->join('odds1x2', 'match.id', '=', 'odds1x2.match_id')
	        		->where('bookmaker_id', '=', '1')
	        		->where('round', '=', $i.". Round")
	        		->distinct('match_id')
			        ->where('league_details_id', '=', 47)
			        ->where('season', '=', $season)
			        ->get();
			        
			        foreach ($matches as $match) {
			        	for($k = 1; $k < 4; $k ++) {
				        	$played = new PlayedSim;
				        	$played->match_id = $match->id;
				        	$played->current_length = $count;
				        	$played->team = $team;
				        	$played->odds = $match->oddsX;
				        	$played->user_id = $k;
				        	$played->save();
				        }
			        	if ($match->resultShort == 'D') {
			        		$count = 0;
			        	} else {
			        		$count = $count + 1;
			        	}
					}
		        }
		    }

		}
	}

	
	public function newSim() {
		$count = Input::get('count');

		$round = PlayedSim::where('current_length', '>=', $count)
				->join('match', 'match.id', '=', 'played_sim.match_id')
				->orderBy('matchDate')
				->first();
		$arg = explode(".", $round->round)[0];
		DB::table('played_sim')->where('user_id', '=', Auth::user()->id)->update(array('bet' => 0.00, 'bsf' => 0.00, 'income' => 0.00, 'profit' => 0));
		// return Redirect::intended("/tmp/$round->season/$arg");
		$res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $arg.'. Round')
			->where('season', '=', "2011-2012")
			->where('current_length', '>=', $count)
			->where('user_id', '=', Auth::user()->id)
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	        // ->get(); 
	        // return $res->get();
	     $c = $res->count();
	     // if ($c == 0) {
	     // 	return View::make('bsim')->with(array('data' => $res->get(), 'round' => $arg, 'season' => Input::get('season'), 'count' => $count, 'income' => 0, 'profit' => 0, 'multiply' => Input::get('multiply'), 'init' => Input::get('init')));
	     // }
	     $bet = Input::get('init')/$c;
	     $matches = $res->get();
	     foreach ($matches as $match) {
	    	$played_sim = PlayedSim::where('id', '=', $match->id)->where('user_id', '=', Auth::user()->id)->first();
	    	// $played_sim->bsf = $bsfpm;
	    	$played_sim->bet = $bet;
	    	$played_sim->income = $played_sim->bet*$played_sim->odds;
	    	$played_sim->profit = $played_sim->bet*$played_sim->odds - $played_sim->bet - $played_sim->bsf;
	    	$played_sim->save();
	    }

		return View::make('bsim')->with(array('data' => $res->get(), 'round' => $arg, 'season' => Input::get('season'), 'count' => $count, 'income' => 0, 'profit' => 0, 'multiply' => Input::get('multiply'), 'init' => Input::get('init'), 'inarr' => '', 'prarr' => ''));

	}

	public function next() {
		$count = Input::get('count');
		$round = Input::get('round');
		$season = Input::get('season');
		$income = Input::get('income');
		$profit = Input::get('profit');
		$mul = Input::get('multiply');
		$bsfrow = Input::get('bsfrow');
		$inarr = Input::get('inarr');
		$prarr = Input::get('prarr');

		$nextround = $round + 1;
		$nextseason = $season;
		if ($season == '2011-2012' && $round == 38) {
			$nextround = 1;
			$nextseason = '2012-2013';
		}
		if ($season == '2012-2013' && $round == 38) {
			$nextround = 1;
			$nextseason = '2013-2014';
		}

		$res1 = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $nextround.'. Round')
			->where('season', '=', $nextseason)
			->where('user_id', '=', Auth::user()->id)
			->where('current_length', '>=', $count)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	        // ->get(); 


		$res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('resultShort', '<>', 'D')
			->where('round', '=', ($round).'. Round')
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
			->where('current_length', '>=', $count)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
// ->sum('bet')->get();
	    $bet = $res->sum('bet');
	    $bsf = $res->sum('bsf') + $bet; 



	    $res2 = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('resultShort', '=', 'D')
			->where('round', '=', ($round).'. Round')
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
			->where('current_length', '>=', $count)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');

	    $income_round = $res2->sum('income'); 
	    $profit_round = $res2->sum('profit');

	    $income = $income + $income_round; 
	    $profit = $profit + $profit_round; 

		$count_matches = $res1->count();

	 //     if ($count_matches == 0) {
		// return View::make('bsim')->with(array('data' => $res1->get(), 'round' => $nextround, 'season' => $nextseason, 'count' => $count, 'income' => $income, 'profit' => $profit, 'multiply' => Input::get('multiply'), 'init' => Input::get('init')));
	 //     }

	    $bsfpm = round($bsf/$count_matches, 2, PHP_ROUND_HALF_UP);
	    $matches = $res1->get();
	    // return $matches;
	    foreach ($matches as $match) {
	    	$played_sim = PlayedSim::where('id', '=', $match->id)->first();
	    	$played_sim->bsf = $bsfpm;
	    	$played_sim->bet = $bsfpm*$mul;
	    	$played_sim->income = $played_sim->bet*$played_sim->odds;
	    	$played_sim->profit = $played_sim->bet*$played_sim->odds - $played_sim->bet - $played_sim->bsf;
	    	$played_sim->save();
	    }


		return View::make('bsim')->with(array('data' => $res1->get(), 'round' => $nextround, 'season' => $nextseason, 'count' => $count, 'income' => $income, 'profit' => $profit, 'multiply' => Input::get('multiply'), 'init' => Input::get('init'), 'inarr' => $inarr.",".$income_round, 'prarr' => $prarr.','.$bsf));

	}

	public function newSim2() {
		$count = Input::get('count');

		$round = PlayedSim::where('current_length', '<=', $count)
				->join('match', 'match.id', '=', 'played_sim.match_id')
				->orderBy('matchDate')
				->first();
		$arg = explode(".", $round->round)[0];
		DB::table('played_sim')->update(array('bet' => 0.00, 'bsf' => 0.00, 'income' => 0.00, 'profit' => 0));
		// return Redirect::intended("/tmp/$round->season/$arg");
		$res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $arg.'. Round')
			->where('season', '=', '2011-2012')
			->where('current_length', '<=', $count)
			->where('user_id', '=', Auth::user()->id)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	        // ->get(); 

	     $bet = Input::get('init')/$res->count();
	     $matches = $res->get();
	     foreach ($matches as $match) {
	    	$played_sim = PlayedSim::where('id', '=', $match->id)->first();
	    	// $played_sim->bsf = $bsfpm;
	    	$played_sim->bet = $bet;
	    	$played_sim->income = $played_sim->bet*$played_sim->odds;
	    	$played_sim->profit = $played_sim->bet*$played_sim->odds - $played_sim->bet - $played_sim->bsf;
	    	$played_sim->save();
	    }
		return View::make('sim')->with(array('data' => $res->get(), 'round' => $arg, 'season' => Input::get('season'), 'count' => $count, 'income' => 0, 'profit' => 0, 'multiply' => Input::get('multiply'), 'init' => Input::get('init'), 'inarr' => '', 'prarr' => ''));

	}

	public function next2() {
		$count = Input::get('count');
		$round = Input::get('round');
		$season = Input::get('season');
		$income = Input::get('income');
		$profit = Input::get('profit');
		$mul = Input::get('multiply');
		$bsfrow = Input::get('bsfrow');
		$inarr = Input::get('inarr');
		$prarr = Input::get('prarr');

		$nextround = $round + 1;
		$nextseason = $season;
		if ($season == '2011-2012' && $round == 38) {
			$nextround = 1;
			$nextseason = '2012-2013';
		}
		if ($season == '2012-2013' && $round == 38) {
			$nextround = 1;
			$nextseason = '2013-2014';
		}

		$res1 = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('round', '=', $nextround.'. Round')
			->where('season', '=', $nextseason)
			->where('current_length', '<=', $count)
			->where('user_id', '=', Auth::user()->id)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	        // ->get(); 


		$res = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('resultShort', '<>', 'D')
			->where('round', '=', ($round).'. Round')
			->where('user_id', '=', Auth::user()->id)
			->where('season', '=', $season)
			->where('current_length', '<=', $count)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
// ->sum('bet')->get();
	    $bet = $res->sum('bet');
	    $bsf = $res->sum('bsf') + $bet; 

	    $count_matches = $res1->count();

	    $bsfpm = round($bsf/$count_matches, 2, PHP_ROUND_HALF_UP);

	    $res2 = Match::join('played_sim', 'played_sim.match_id', '=', 'match.id')
			->where('resultShort', '=', 'D')
			->where('round', '=', ($round).'. Round')
			->where('user_id', '=', Auth::user()->id)
			->where('season', '=', $season)
			->where('current_length', '<=', $count)
			
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');

	    $income_round = $res2->sum('income'); 
	    $profit_round = $res2->sum('profit');

	    $income = $income + $income_round; 
	    $profit = $profit + $profit_round; 

	    $matches = $res1->get();
	    // return $matches;
	    foreach ($matches as $match) {
	    	$played_sim = PlayedSim::where('id', '=', $match->id)->where('user_id', '=', Auth::user()->id)->first();
	    	$played_sim->bsf = $bsfpm;
	    	$played_sim->bet = $bsfpm*$mul;
	    	$played_sim->income = $played_sim->bet*$played_sim->odds;
	    	$played_sim->profit = $played_sim->bet*$played_sim->odds - $played_sim->bet - $played_sim->bsf;
	    	$played_sim->save();
	    }

	    $bsfrow[$round] = $bsf;

		return View::make('sim')->with(array('data' => $res1->get(), 'round' => $nextround, 'season' => $nextseason, 'count' => $count, 'income' => $income, 'profit' => $profit, 'multiply' => Input::get('multiply'), 'init' => Input::get('init'), 'inarr' => $inarr.",".$income_round, 'prarr' => $prarr.','.$bsf));

	}

	public function save() {
		$input = Input::all();
		if ($input['column'] === 9 || $input['column'] === '9') {
		
		$played = PlayedSim::where('id', '=', $input['id'])->where('match_id', '=', $input['row_id'])->where('user_id', '=', Auth::user()->id)->first();
		$played->bet = $input['value'];
		$played->income = $played->bet*$played->odds;
		$played->profit = $played->income - $played->bsf - $played->bet;
		$played->save();

	}
	if ($input['column'] === 8 || $input['column'] ==='8') {

		$played = PlayedSim::where('id', '=', $input['id'])->where('match_id', '=', $input['row_id'])->where('user_id', '=', Auth::user()->id)->first();
		$played->bsf = $input['value'];
		$played->income = $played->bet*$played->odds;
		$played->profit = $played->income - $played->bsf - $played->bet;
		$played->save();
	}

		$p = PlayedSim::where('id', '=', $input['id'])->where('match_id', '=', $input['row_id'])->where('user_id', '=', Auth::user()->id)->firstOrFail();


	// print_r($_POST);
	echo $p->bet."#".$p->odds."#".$p->income."#".$p->profit."#".$p->bsf;
	}


	




}
