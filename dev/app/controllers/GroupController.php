<?php

class GroupController extends \BaseController {

	public function getGamesForGroup($league_details_id) {
		$games = User::find(Auth::user()->id)->games()->lists('match_id');
		// return $games;
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $league_details_id)->first();
		$data = Groups::where('league_details_id', '=', $league_details_id)
				->where('state', '=', '2')
				->first()
				->matches()
				->join('games', 'games.match_id', '=', 'match.id')
				->join('standings', 'games.standings_id', '=', 'standings.id')
				->where('user_id', '=', Auth::user()->id)
				->orderBy('bet', 'asc')
				->orderBy('matchDate')
				->orderBy('matchTime')
				->get();
		return View::make('matches')->with(['data' => $data, 'pool' => $pool, 'league_details_id' => $league_details_id]);
	} 
}
