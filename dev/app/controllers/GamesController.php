<?php

class GamesController extends \BaseController {
	protected $layout = 'layout';
	
	public function getGroups(){
		$league_details_ids = Settings::where('user_id', '=', Auth::user()->id)->lists('league_details_id');
		if (count($league_details_ids) > 0) {
			$data = LeagueDetails::whereIn('id', $league_details_ids)->get(['country', 'fullName', 'id']);
		} else {
			$data = array();
		}
		return View::make('games')->with(['data' => $data]);
	}

	public function getMatchOddsForGames($groups_id) {
		$ids = Groups::find($groups_id)->matches()->lists('id');

		$games = Games::whereIn('match_id', $ids)->where('user_id', '=', Auth::user()->id)->get();
		// return $games;
		foreach ($games as $game) {
			Games::getMatchOddsForGame($game);
		}
		Updater::recalculateGroup($groups_id, Auth::user()->id);
		return Redirect::back();
	}

	public function saveTable() {

		$game_id = Input::get('row_id');
		// return $game_id;
		$game = Games::find($game_id);
		// return $game->id;
		$value = Input::get('value');
		$col = Input::get('column');
		$bsf = "";
		if ($col == 8 || $col == '8') {
			$game->bsf = $value;
			$game->save();

			$m = Match::find($game->match_id);
			$matches = Groups::find($m->groups_id)->matches()->lists('id');
			// return $matches;
			$bsf = Games::where('user_id', '=', Auth::user()->id)->whereIn('match_id', $matches)->sum('bsf');
			$pool = Pools::where('user_id', '=', Auth::user()->id)->where('league_details_id', '=', $m->league_details_id)->first();
			$pool->current = $bsf;
			$pool->save();
		}
		if ($col == 9 || $col == '9') {
			$game->bet = $value;
			$game->income = $game->odds * $value;
			$game->save();

		}
		if ($col == 10 || $col == '10') {
			$game->odds = $value;
			$game->income = $value * $game->bet;
			$game->save();

		}
			// 	break;
			// case 8:
			// 	$game->bet = $value;
			// 	$game->income = $game->odds * $value;
			// 	$game->save();
			// 	break;
			// case 9:
			// 	$game->odds = $value;
			// 	$game->income = $value * $game->bet;
			// 	$game->save();
			// 	break;

		
		return $game->bsf."#".$game->bet."#".$game->odds."#".$game->income."#".$bsf;
	}

	public function cloneMatch($game_id) {
		$game = Games::find($game_id);
		$nGame = new Games;
		$nGame->match_id = $game->match_id;
		$nGame->user_id = $game->user_id;
		$nGame->standings_id = $game->standings_id;
		// Games::create(array('match_id' => $game->match_id, 'user_id', $game->user_id));
		$nGame->save();
		$m = Match::find($game->match_id);
		// return $gr;
		$setting = Settings::where('user_id', '=', Auth::user()->id)
			->where('league_details_id', '=', $m->league_details_id)
			->first(['multiplier']);
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $m->league_details_id)->first();


		Games::recalculate($m->groups_id, $setting->multiplier, $pool->amount, Auth::user()->id);
		return Redirect::back();

	}

	public function removeMatch($game_id) {
		$game = Games::find($game_id);
		$m = Match::find($game->match_id);
		// return $gr;
		$setting = Settings::where('user_id', '=', Auth::user()->id)
			->where('league_details_id', '=', $m->league_details_id)
			->first(['multiplier']);
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $m->league_details_id)->first();
		$game->delete();
		Games::recalculate($m->groups_id, $setting->multiplier, $pool->amount, Auth::user()->id);
		return Redirect::back();

	}

}