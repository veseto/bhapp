<?php

class SimulatorController extends BaseController {

	public function getSimMatches($country='', $league='') {

		$league_details_id = LeagueDetails::where('country', '=', $country)
				->where('fullName', '=', $league)->first()->id;
        
		$count = Simulator::where('user_id', '=', Auth::user()->id)->count();
		if ($count == 0) {

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
		        ->get();
		       	
		       	// ret
		       	if ($team == 'Arles-Avignon'){ 
					
					return View::make('simulator.simulator')->with(array('data' => $matches, 'country' => $country, 'league' => $league, 'count' => 0, 'init' => 0, 'multiply' => 0, 'offset' => 0, 'season' => 0, 'lt' => '<'));
				}
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
		return View::make('simulator.simulator')->with(array('country' => $country, 'league' => $league, 'count' => 0, 'init' => 0, 'multiply' => 0, 'offset' => 0, 'season' => 0, 'lt' => '<'));
	}	

	public function newSim() {
		$country = Input::get('country');
		$league = Input::get('league');
		$count = Input::get('count');
		$roundoffset = Input::get('offset');
		$seasonoffset = Input::get('season');
		$income = Input::get('income');
		$profit = Input::get('profit');
		$mul = Input::get('multiply');
		$init = Input::get('init');
		$lt = Input::get('lt');

		$roundoffset = ($roundoffset == 0)?1:$roundoffset;

		$league_details_id = LeagueDetails::where('country', '=', $country)
					->where('fullName', '=', $league)->first()->id;


		$seasons = ImportedSeasons::where('league_details_id', '=', $league_details_id)
	        		->distinct()
	        		->orderBy('season', 'desc')
	        		->take(3)
	        		->lists('season');
	    // return $roundoffset;
        sort($seasons);

		for($i = $seasonoffset; $i < 3; $i ++) {
			$rounds = Match::where('season', '=', $seasons[$i])
				->where('league_details_id', '=', $league_details_id)
				->distinct('round')
				->orderBy('matchDate')
				->lists('round');
				// return $rounds;
			for($j = $roundoffset - 1; $j < count($rounds); $j ++) {
				$res = $this->getQuery($league_details_id, $seasons[$i], $rounds[$j], $lt, $count);
				if ($res->count() > 0) {
					return View::make('simulator.simulator')->with(array('data' => $res->get(), 'country' => $country, 'league' => $league, 'count' => $count, 'init' => $init, 'multiply' => $mul, 'offset' => $roundoffset, 'season' => $seasonoffset, 'lt' => $lt));
				}

			}
		}
		// 
		return View::make('simulator.simulator')->with(array('data' => $res->get(), 'country' => $country, 'league' => $league, 'count' => $count, 'init' => $init, 'multiply' => $mul, 'offset' => $roundoffset, 'season' => $seasonoffset, 'lt' => $lt));

	}

	private function getQuery($league_details_id, $season, $round, $lt, $count) {
		return Match::join('simulator', 'simulator.match_id', '=', 'match.id')
			->where('round', '=', $round)
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
		    ->where('league_details_id', '=', $league_details_id)
			->where('current_length', $lt, $count)
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	}

	public function next() {
		$count = Input::get('count');
		$round = Input::get('round');
		$season = Input::get('season');
		$income = Input::get('income');
		$profit = Input::get('profit');
		$mul = Input::get('multiply');
		$bsfrow = Input::get('bsfrow');
		
		$nextround = $round + 1;
		$nextseason = $season;
		if ($season == '2012' && $round == 38) {
			$nextround = 1;
			$nextseason = '2013';
		}
		if ($season == '2013' && $round == 38) {
			$nextround = 1;
			$nextseason = '2013-2014';
		}

		$res1 = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
			->where('round', '=', $nextround.'. Round')
			->where('season', '=', $nextseason)
			->where('user_id', '=', Auth::user()->id)
			->where('current_length', '>=', $count)
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');
	        // ->get(); 


		$res = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
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

	    $count_matches = $res1->count();

	    $bsfpm = round($bsf/$count_matches, 2, PHP_ROUND_HALF_UP);

	    $res2 = Match::join('simulator', 'simulator.match_id', '=', 'match.id')
			->where('resultShort', '=', 'D')
			->where('round', '=', ($round).'. Round')
			->where('season', '=', $season)
			->where('user_id', '=', Auth::user()->id)
			->where('current_length', '>=', $count)
	        ->orderBy('season')
	        ->orderBy('matchDate')
	        ->orderBy('home');

	    $income = $income + $res2->sum('income'); 
	    $profit = $profit + $res2->sum('profit'); 

	    $matches = $res1->get();
	    // return $matches;
	    foreach ($matches as $match) {
	    	$simulator = Simulator::where('id', '=', $match->id)->first();
	    	$simulator->bsf = $bsfpm;
	    	$simulator->bet = $bsfpm*$mul;
	    	$simulator->income = $simulator->bet*$simulator->odds;
	    	$simulator->profit = $simulator->bet*$simulator->odds - $simulator->bet - $simulator->bsf;
	    	$simulator->save();
	    }

	    $bsfrow[$round] = $bsf;

		return View::make('bsim')->with(array('data' => $res1->get(), 'round' => $nextround, 'season' => $nextseason, 'count' => $count, 'income' => $income, 'profit' => $profit, 'multiply' => Input::get('multiply'), 'init' => Input::get('init')));

	}

}