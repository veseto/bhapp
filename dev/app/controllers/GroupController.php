<?php

class GroupController extends \BaseController {

	public function getGamesForGroup($league_details_id) {
		$games = User::find(Auth::user()->id)->games()->lists('match_id');
		// return $games;
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $league_details_id)->first();
		$gr = Groups::where('league_details_id', '=', $league_details_id)
				->where('state', '=', '2')
				->first();
		$data = $gr->matches()
				->join('games', 'games.match_id', '=', 'match.id')
				->join('bookmaker', 'games.bookmaker_id', '=', 'bookmaker.id')
				->join('game_type', 'games.game_type_id', '=', 'game_type.id')
				->join('standings', 'games.standings_id', '=', 'standings.id')
				->select(DB::raw('`games`.id as games_id, `games`.*, `standings`.*, `match`.*, bookmaker.*, game_type.*'))
				->where('user_id', '=', Auth::user()->id)
				->orderBy('bet', 'asc')
				->orderBy('matchDate')
				->orderBy('matchTime')
				->get();
		// return $data;
		return View::make('matches')->with(['data' => $data, 'pool' => $pool, 'league_details_id' => $league_details_id, 'group' => $gr->id]);
	} 
}
