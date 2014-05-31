<?php

class GroupController extends \BaseController {

	public function getGamesForGroup($league_details_id) {
		$games = User::find(Auth::user()->id)->games()->lists('match_id');
		// return $games;
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $league_details_id)->first();
		$gr = Groups::where('league_details_id', '=', $league_details_id)
				->where('state', '=', '2')
				->first();
		$games = Games::where('user_id', '=', Auth::user()->id)->where('groups_id', '=', $gr->id)->lists('standings_id');
		$data = $gr->matches()
				->join('games', 'games.match_id', '=', 'match.id')
				->join('bookmaker', 'games.bookmaker_id', '=', 'bookmaker.id')
				->join('game_type', 'games.game_type_id', '=', 'game_type.id')
				->join('standings', 'games.standings_id', '=', 'standings.id')
				->select(DB::raw('`games`.id as games_id, `games`.*, `standings`.*, `match`.*, bookmaker.*, game_type.*'))
				->where('user_id', '=', Auth::user()->id)
				->orderBy('matchDate')
				->orderBy('matchTime')
				->orderBy('streak')
				->get();
		// return $data;
		$standings = Standings::whereNotIn('id', $games)->lists('team');
		$grey = array();
		// foreach ($standings as $st) {
			$m1 = $gr->matches()
				->whereIn('home', $standings)
				->join('standings', 'match.home', '=', 'standings.team')
				->orderBy('matchDate')
				->orderBy('matchTime')
				->orderBy('streak')
				->get();
		// }
			$m2 = $gr->matches()
				->whereIn('away', $standings)
				->join('standings', 'match.away', '=', 'standings.team')
				->orderBy('matchDate')
				->orderBy('matchTime')
				->orderBy('streak')
				->get();
		$grey = [$m1, $m2];
		return View::make('matches')->with(['data' => $data, 'grey' => $grey, 'pool' => $pool, 'league_details_id' => $league_details_id, 'group' => $gr->id]);
	} 
}
