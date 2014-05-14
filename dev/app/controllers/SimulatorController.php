<?php

class SimulatorController extends BaseController {

	public function getSimMatches($country='', $league='') {

		$league_details_id = LeagueDetails::where('country', '=', $country)
				->where('fullName', '=', $league)->first()->id;
        
		$tmp = Simulator::join('match', 'simulator.match_id', '=', 'match.id')
					->where('user_id', '=', Auth::user()->id)
					->where('league_details_id', '=', $league_details_id)
					->get();
		if (count($tmp) == 0) {

	        $seasons = ImportedSeasons::where('league_details_id', '=', $league_details_id)
	        		->distinct()
	        		->orderBy('season', 'desc')
	        		->take(3)
	        		->lists('season');

	        sort($seasons);

			$teams = Match::distinct('home')->where('league_details_id', '=', $league_details_id)->whereIn('season', $seasons)->lists('home');
	        
			foreach ($teams as $team) {
				$count = 0;
				$matches = Match::where(function($query) use ($team)
		        {
		            $query->where('home', '=', $team)
		                  ->orWhere('away', '=', $team);
		        })
		        ->join('mapping', 'mapping.round', '=', 'match.round')
        		->join('odds1x2', 'match.id', '=', 'odds1x2.match_id')
        		->where('bookmaker_id', '=', '1')
		        ->where('league_details_id', '=', $league_details_id)
		        ->whereIn('season', $seasons)
		        ->orderBy('season')
		        ->orderBy('int')
		        ->distinct('match.id')
		        ->get();
		       	
		    
		        foreach ($matches as $match) {
			        	
			        	$played = new Simulator;

			        	$played->match_id = $match->id;
			        	$played->current_length = $count;
			        	$played->team = $team;
			        	$played->odds = $match->oddsX;
			        	$played->user_id = Auth::user()->id;
			        	$played->save();
		        	if ($match->resultShort == 'D') {
		        		$count = 0;
		        	} else {
		        		$count = $count + 1;
		        	}
		        }

			}
		}
		return View::make('simulator.simulator')->with(array('country' => $country, 'league' => $league, 'count' => 0, 'init' => 0, 'multiply' => 0, 'offset' => 0, 'season' => 0, 'lt' => '<='));
	}	

	public function newSim() {
		$country = Input::get('country');
		$league = Input::get('league');
		$count = Input::get('count');
		$roundoffset = Input::get('offset');
		$seasonoffset = Input::get('season');
		// $income = Input::get('income');
		$profit = Input::get('profit');
		$mul = Input::get('multiply');
		$init = Input::get('init');
		$lt = Input::get('lt');

		$bet = $init;
		$bsf = 0;
		$account = 0;
		$income = 0;
		$accountstate = 0;

		$league_details_id = LeagueDetails::where('country', '=', $country)
					->where('fullName', '=', $league)->first()->id;


		$seasons = ImportedSeasons::where('league_details_id', '=', $league_details_id)
	        		->distinct()
	        		->orderBy('season', 'desc')
	        		->take(3)
	        		->lists('season');
	    // return $roundoffset;
        sort($seasons);
        $result = array();

		for($i = $seasonoffset; $i < 3; $i ++) {
			$rounds = Match::where('season', '=', $seasons[$i])
				->where('league_details_id', '=', $league_details_id)
				->distinct('round')
				->lists('round');

			for($j = 1 + $roundoffset; $j <= count($rounds); $j ++) {
				$result[$seasons[$i]][$j] = array();
				
				$res_c = Match::join('mapping', 'mapping.round', '=', 'match.round')
					->where('int', '=', $j)
					->where('season', '=', $seasons[$i])
				    ->where('league_details_id', '=', $league_details_id);
				    
				$result[$seasons[$i]][$j]['all_matches'] = $res_c->count();
				$result[$seasons[$i]][$j]['all_draws'] = $res_c->where('resultShort', '=', 'D')->count();

				
				$res = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
		        	->join('mapping', 'mapping.round', '=', 'match.round')
					->where('int', '=', $j)
					->where('season', '=', $seasons[$i])
					->where('user_id', '=', Auth::user()->id)
				    ->where('league_details_id', '=', $league_details_id)
					->where('current_length', $lt, $count)
			        ->orderBy('season')
			        ->orderBy('home');
				$roundMatches = $res->get();
				$cm = count($roundMatches);
				if ($cm > 0) {
					$result[$seasons[$i]][$j]['all_played'] = $cm;
					$bsfpm = round($bsf/$cm, 0, PHP_ROUND_HALF_UP);
					$betpm = round($bet/$cm, 0, PHP_ROUND_HALF_UP);
					foreach ($roundMatches as $rm) {
						$simulator = Simulator::where('id', '=', $rm->id)->where('user_id', '=', Auth::user()->id)->first();
				    	$simulator->bsf = $bsfpm;
				    	$simulator->bet = $betpm;
				    	$simulator->income = $simulator->bet*$simulator->odds;
				    	$simulator->profit = $simulator->bet*$simulator->odds - $simulator->bet - $simulator->bsf;
				    	$simulator->save();
					}

					$res1 = $this->getQuery($league_details_id, $seasons[$i], $j, $lt, $count);

					$account = $accountstate - $bet;

					$draws = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
						->join('mapping', 'mapping.round', '=', 'match.round')
						->where('int', '=', $j)
						->where('resultShort', '=', 'D')
						->where('season', '=', $seasons[$i])
						->where('user_id', '=', Auth::user()->id)
					    ->where('league_details_id', '=', $league_details_id)
						->where('current_length', $lt, $count);

					$income = round($draws->sum('income'), 0, PHP_ROUND_HALF_UP);

				    $result[$seasons[$i]][$j]['draws_played'] = $draws->count();

				    if ($income == NULL || $income == '' || !$income) {
						$income = 0;
					} 

					$result[$seasons[$i]][$j]['bet'] = $bet;
					$result[$seasons[$i]][$j]['bsf'] = $bsf;
					$result[$seasons[$i]][$j]['income'] = $income;


					if ($account < 0) {
						$adj = -$account;
						$account = 0;
					} else {
						$adj = 0;
					}
					$result[$seasons[$i]][$j]['acc'] = $account;
					$result[$seasons[$i]][$j]['adj'] = $adj;
					$result[$seasons[$i]][$j]['real'] = $account + $income;


					$accountstate = $account + $income;

					$account = $account - $bet + $income;



					$bet = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
						->join('mapping', 'mapping.round', '=', 'match.round')
						->where('int', '=', $j)
						->where('season', '=', $seasons[$i])
						->where('user_id', '=', Auth::user()->id)
					    ->where('league_details_id', '=', $league_details_id)
						->where('current_length', $lt, $count)
				        ->orderBy('season')
				        ->orderBy('home')->where('resultShort', '<>', 'D')->sum('bet');
					$bsf = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
						->join('mapping', 'mapping.round', '=', 'match.round')
						->where('int', '=', $j)
						->where('season', '=', $seasons[$i])
						->where('user_id', '=', Auth::user()->id)
					    ->where('league_details_id', '=', $league_details_id)
						->where('current_length', $lt, $count)
				        ->orderBy('season')
				        ->orderBy('home')->where('resultShort', '<>', 'D')->sum('bsf') + $bet;

				    if ($bsf == 0) {
				    	$bsf = $init;
				    }
					$bet = round($bsf*$mul, 0, PHP_ROUND_HALF_UP);
					$fin = $res->get();
					

					// return View::make('simulator.simulator')->with(array('data' => $res->get(), 'country' => $country, 'league' => $league, 'count' => $count, 'init' => $init, 'multiply' => $mul, 'offset' => $roundoffset, 'season' => $seasonoffset, 'lt' => $lt));
				} else {
					$result[$seasons[$i]][$j]['acc'] = $account;
					$result[$seasons[$i]][$j]['bet'] = $bet;
					$result[$seasons[$i]][$j]['bsf'] = $bsf;
					$result[$seasons[$i]][$j]['income'] = $income;
					$result[$seasons[$i]][$j]['adj'] = 0;
					$result[$seasons[$i]][$j]['real'] = $account + $income;
					$result[$seasons[$i]][$j]['all_played'] = 0;
					$result[$seasons[$i]][$j]['draws_played'] = 0;

				}

			}
		}
		

		// return $result;
		return View::make('simulator.simulator')->with(array('data' => $result, 'country' => $country, 'league' => $league, 'count' => $count, 'init' => $init, 'multiply' => $mul, 'offset' => $roundoffset, 'season' => $seasonoffset, 'lt' => $lt));

	}

	private function getQuery($league_details_id, $season, $j, $lt, $count) {
		return Match::join('simulator', 'simulator.match_id', '=', 'match.id')
			->join('mapping', 'mapping.round', '=', 'match.round')
			->where('int', '=', $j)
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
		    ->where('league_details_id', '=', $league_details_id)
			->where('current_length', $lt, $count)
	        ->orderBy('season')
	        ->orderBy('home');
	}

}