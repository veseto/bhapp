<?php

class GamesController extends \BaseController {

	
	public function getGroups(){
		$league_details_ids = Settings::where('user_id', '=', Auth::user()->id)->lists('league_details_id');
		if (count($league_details_ids) > 0) {
			$data = LeagueDetails::whereIn('id', $league_details_ids)->get(['country', 'fullName', 'id']);
		} else {
			$data = array();
		}
		return View::make('games')->with(['data' => $data]);
	}

}