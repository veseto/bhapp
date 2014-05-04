<?php

class SeriesController extends BaseController {



	public function calculatePPSSeries() {
		$start = time();
		$teams = Match::whereIn('league_details_id', array(7, 8, 9, 10))->distinct('home')->get(array('home'));
		
		foreach ($teams as $team) {
			
			$regexp = $team->home;
			
		    // $ids = \DB::table('series')->lists('end_match_id');

			$matches = Match::where(function($query) use ($regexp)
	            {
	                $query->where('home', '=', $regexp)
	                      ->orWhere('away', '=', $regexp);
	            })
				// ->whereNotIn('id', $ids)
				->orderBy('matchDate', 'asc')->orderBy('matchTime', 'asc')->get();
			$prev_season = '2003-2004';
			$prev_league = '-1';
			foreach ($matches as $match) {
				for ($i = 1; $i < 5; $i ++) {
					$note = "";
					$series = Series::where('team', '=', $team->home)->where('active', '=', 1)->where('game_type_id', '=', $i)->first();
					if ($series == NULL) {
						$series = new Series;
						$series->team = $team->home;
						$series->game_type_id = $i;
						$series->current_length = 0;
						$series->start_match_id = $match->id;
						$series->active = 1;
						$series->save();
					}

					$series->current_length = $series->current_length + 1;
					$series->end_match_id = $match->id;

					if ($this->endSeries($match, $i)) {
						$series->active = 0;
						$duplicate = Series::where('start_match_id', '=', $series->start_match_id)
						->where('end_match_id', '=', $series->end_match_id)
						->where('team', '=', $team->home)
						->where('current_length', '=', $series->current_length)
						->where('game_type_id', '=', $series->game_type_id)->first();
						if ($duplicate) {
							$duplicate->delete();
						}
					}
					
					if ($match->league_details_id != $prev_league) {
						$note = "continued from $prev_league in ".$match->league_details_id." league";
					}
					$series->note = $note;

					$series->save();
				}
				$prev_league = $match->league_details_id;
				$prev_season = $match->season;
				if ($match->resultShort == '-' || $match->resultShort == '')
					break 1;
			}
		}
		$time = time() - $start;
		return "ended in $time sec";
	}

	public function endSeries($match, $type) {
		switch ($type) {
			case '1':
				if($match->resultShort == 'D')
					return true;
				else return false;
			case '2':
				if ($match->resultShort == 'D' && $match->homeGoals == 0 && $match->awayGoals == 0)
					return true;
				else return false;
			case '3':
				if ($match->resultShort == 'D' && $match->homeGoals == 1 && $match->awayGoals == 1)
					return true;
				else return false;
			case '4':
				if ($match->resultShort == 'D' && $match->homeGoals == 2 && $match->awayGoals == 2)
					return true;
				else return false;
			case '5':
				if($match->resultShort == 'D')
					return true;
				else return false;
			case '6':
				if ($match->resultShort == 'D' && $match->homeGoals == 0 && $match->awayGoals == 0)
					return true;
				else return false;
			case '7':
				if ($match->resultShort == 'D' && $match->homeGoals == 1 && $match->awayGoals == 1)
					return true;
				else return false;
			case '8':
				if ($match->resultShort == 'D' && $match->homeGoals == 2 && $match->awayGoals == 2)
					return true;
				else return false;
		}
	}

	public function getSeries() {

		$res = DB::table('series')->join('match', 'match.id', '=', 'series.start_match_id')
		->where('team', '=', 'Manchester United')->where('season', '=', '2013-2014')->get();
		return $res;
	}

	public function updateAllPPSSeries($team) {
		$today = date('Y-m-d', time());
		$matches = Match::where('matchDate', '<=', $today)->where('resultShort', '=', '-')->get();
		foreach ($matches as $match) {
			$match = Match::updateMatchDetails($match->id);
			
			for ($i = 0; $i < 5; $i ++) {
				$series = Series::where('end_match_id', '=', $match->id)->where('game_type_id', '=', $i)->where('active', '=', 1)->first();
				if ($series == NULL) {
						$series = new Series;
						$series->team = $team->home;
						$series->game_type_id = $i;
						$series->current_length = 0;
						$series->start_match_id = $match->id;
						$series->active = 1;
						$series->save();
					}

				$series->current_length = $series->current_length + 1;
				$series->end_match_id = $match->id;
				$next_id = Match::getNextMatchForTeam($team->home, $match)->id;
				if ($this->endSeries($match, $i)) {
					$series->active = 0;
					$duplicate = Series::where('start_match_id', '=', $series->start_match_id)
					->where('end_match_id', '=', $series->end_match_id)
					->where('team', '=', $team->home)
					->where('current_length', '=', $series->current_length)
					->where('game_type_id', '=', $series->game_type_id)->first();
					if ($duplicate) {
						$duplicate->delete();
					}
					$series->save();
					$series = new Series;
					$series->team = $team->home;
					$series->game_type_id = $i;
					$series->current_length = 0;
					$series->start_match_id = $next_id;
					$series->end_match_id = $next_id;
					$series->active = 1;
					$series->save();

				} else {
					$series->end_match_id = $next_id;
					$series->save();

				}
			}
		}
	}

	public static function getSeriesForMatches($league_details_id, $season, $game_type_id) {
		$teams = Match::matchesForSeason($league_details_id, $season)->distinct('home')->get(array('home'));
		$res = array();
		foreach ($teams as $team) {
			// $seq[$team->home] = array();
			$res[$team->home] = DB::table('series')
			->join('match', 'match.id', '=', 'series.end_match_id')
			->where('season', '=', $season)
			->where('team', '=', $team->home)
			->where('game_type_id', '=', $game_type_id)
			->orderBy('matchDate', 'asc')->get();
		}
		return $res;
	}
}