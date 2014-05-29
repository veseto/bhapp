<?php

class Updater {

	public static function update() {
		$time = time();
		$allMatches = Updater::getAllMatchesForUpdate();
		foreach ($allMatches as $match) {
			$match = Updater::updateDetails($match);
			try {
				$match->id;
			} catch (ErrorException $e) {
				continue;
			}
			if ($match->groups_id != 0) {
				$games = Updater::getAllSpecialGamesForMatch($match->id);
				foreach ($games as $game) {
					return Updater::updatePool($game, $match->resultShort);
					Updater::recalculateGroup($match->groups_id, $game->user_id);
				}
				if (Updater::isLastGameInGroup($match)) {

					return Updater::updateGroup($match->groups_id);
				}
			}
		}
		return (time() - $time)." sec for ".count($allMatches)." matches";
	}

	public static function updateGroup($groups_id) {
		$matches = Match::where('groups_id', '=', $groups_id)->get(['id', 'resultShort']);
		foreach ($matches as $match) {
			$games = Games::where('match_id', '=', $match->id)->get();
			foreach ($games as $game) {
				Updater::updatePool($game, $match->resultShort);
			}
		}
		$gr = Groups::find($groups_id);
		print_r($gr);
		$current = Groups::firstOrCreate(['league_details_id' => $gr->league_details_id, 'state' => 3, 'round' => ($gr->round + 1)]);
		$gr->state = 1;
		$gr->save();
		$current->state = 2;
		$current->save();
		$next = Groups::firstOrCreate(['league_details_id' => $gr->league_details_id, 'state' => 3, 'round' => ($current->round + 1)]);
		// return $next;
		Parser::parseMatchesForGroup($next);
		Parser::parseMatchesForGroup($current);
		Parser::parseLeagueSeries($current);
		$ids = Settings::where('league_details_id', '=', $current->league_details_id)->lists('user_id');
		foreach ($ids as $id) {
			Updater::recalculateGroup($current->id, $id);
		}
	}

	public static function isLastGameInGroup($match) {
		$id = Match::where('groups_id', '=', $match->groups_id)
			->orderBy('matchDate', 'desc')
			->orderBy('matchTime', 'desc')
			->first()->id;
		return ($id == $match->id)." ";
	}

	public static function getAllMatchesForUpdate() {
		date_default_timezone_set('Europe/Sofia');
		$now = date('Y-m-d H:i:s');
		$start = explode(' ', date( "Y-m-d H:i:s", strtotime( "$now - 2 hours" )));
		return Match::where(function($q) use ($start) {
				$q->where('matchDate', '<', $start[0])
					->orWhere(function($query) use ($start)
			            {
			                $query->where('matchDate', '=', $start[0])
			                      ->where('matchTime', '<=', $start[1]);
			            });
				})
				->where(function($query) {
		                $query->where('resultShort', '=', '')
		                      ->orWhere('resultShort', '=', '-');
		            })
				->where('state', '<>', 'canceled')
				->where('state', '<>', 'Awarded')
				->orderBy('matchDate')
				->orderBy('matchTime')
				->get();
		// return Groups::find(2)->matches;
	}

	public static function updateDetails($match) {
		return Match::updateMatchDetails($match);
	}

	public static function getAllSpecialGamesForMatch($match_id) {
		return Games::where('match_id', '=', $match_id)
			->where('special', '=', 1)
			->get();
	}

	public static function updatePool($game, $resultShort) {
		$user_id = $game->user_id;
		$match = Match::find($game->match_id);
		if ($match != NULL){
			$league_details_id = $match->league_details_id;
		} else {
			return;
		}
		$pool = Pools::where('user_id', '=', $user_id)->where('league_details_id', '=', $league_details_id)->first();
		if ($resultShort == 'D') {
			$pool->amount = $pool->amount - $game->bsf;
			$pool->income = $pool->income + $game->income;
		} else {
			$pool->amount = $pool->amount + $game->bet;
		}
		$pool->save();
		$pool;
	}

	public static function recalculateGroup($groups_id, $user_id) {
		$gr = Groups::find($groups_id);
		$setting = Settings::where('user_id', '=', $user_id)
			->where('league_details_id', '=', $gr->league_details_id)
			->first(['from', 'to', 'multiplier']);
		$from = $setting->from;
		$to = $setting->to;
		$teams = array();
		for($i = 0; $i < 100; $i ++) {
			$count = Standings::where('league_details_id', '=', $gr->league_details_id)
					->where('streak', '>=', $i);
			if ($count->count() <= $to){
				if ($count->count() < $from) {
					$teams = Standings::where('league_details_id', '=', $gr->league_details_id)
					->where('streak', '>=', $i - 1)->lists('team', 'id');

					break 1;
				} else { 
					$teams = Standings::where('league_details_id', '=', $gr->league_details_id)
					->where('streak', '>=', $i)->lists('team', 'id');

				}
				break 1;
			} 
		}
		$pool = User::find($user_id)->pools()->where('league_details_id', '=', $gr->league_details_id)->first();
		$bsfpm = $pool->amount / count($teams);
		$bpm = $pool->amount * $setting->multiplier / count($teams);
		// $bsfpm = $pool;
		$recalc = false;
		foreach ($teams as $st_id => $team) {
			$match = $gr->matches()->where(function ($query) use ($team) {
	             $query->where('home', '=', $team)
	                   ->orWhere('away', '=', $team);
	        })->where(function ($query) {
	             $query->where('resultShort', '=', '-')
	                   ->orWhere('resultShort', '=', '');
	        })
	        ->orderBy('matchDate')
			->orderBy('matchTime')
	        ->get();
	        if (count($match) == 0) {
	        	$recalc = true;
	        } else if (count($match) == 1) {
	        	$match = $match[0];
				//TODO: add setting based bookmaker && special match check
				$game = Games::firstOrCreate(['user_id' => $user_id, 'match_id' => $match->id, 'game_type_id' => 1, 'bookmaker_id' => 1, 'standings_id' =>$st_id]);
				$game->bet = $bpm;
				$game->bsf = $bsfpm;
				// $game->odds = 3;
				$game->income = $game->odds * $game->bet;
				$game->save();
			} else if (count($match) > 1) {
				$match = $match[0];
				$game = Games::firstOrCreate(['user_id' => $user_id, 'match_id' => $match->id, 'game_type_id' => 1, 'bookmaker_id' => 1, 'standings_id' =>$st_id]);
				$game->bet = $bpm;
				$game->bsf = $bsfpm;
				// $game->odds = 3;
				$game->special = 1;
				$game->income = $game->odds * $game->bet;
				$game->save();
			}
		}
		if ($recalc) {
			return Games::recalculate($gr->id, $setting->multiplier, $pool->amount, $user_id);
		}
	}

}