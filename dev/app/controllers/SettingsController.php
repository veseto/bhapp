<?php

class SettingsController extends BaseController {

	public function display() {
		// $settings = Settings::where('user_id', '=', Auth::user()->id);

		$ppm = array();

		$pps = array();

		$league = LeagueDetails::orderBy('country')->get();
		
		foreach ($league as $l) {
			if ($l->ppm == 1) {
				if (!array_key_exists($l->country, $ppm)) {
				$ppm[$l->country] = array();
				}
				// $ppm[$l->country][0] = $l->id;
				// $ppm[$l->country][5] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 5)->where('user_id', '=', Auth::user()->id)->first();
				// $ppm[$l->country][6] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 6)->where('user_id', '=', Auth::user()->id)->first();
				// $ppm[$l->country][7] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 7)->where('user_id', '=', Auth::user()->id)->first();
				// $ppm[$l->country][8] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 8)->where('user_id', '=', Auth::user()->id)->first();
			
			}
			if (!array_key_exists($l->country, $pps)) {
				$pps[$l->country] = array();
			}
			if (!array_key_exists($l->fullName, $pps[$l->country])) {
				$pps[$l->country][$l->fullName] = array();
			}
			// $pps[$l->country][$l->fullName][0] = $l->id;
			// $pps[$l->country][$l->fullName][1] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 1)->where('user_id', '=', Auth::user()->id)->first();
			// $pps[$l->country][$l->fullName][2] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 2)->where('user_id', '=', Auth::user()->id)->first();
			// $pps[$l->country][$l->fullName][3] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 3)->where('user_id', '=', Auth::user()->id)->first();
			// $pps[$l->country][$l->fullName][4] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 4)->where('user_id', '=', Auth::user()->id)->first();
		}
		return View::make('settings')->with(array('ppm' => $ppm, 'pps' => $pps));
	}


	public function createEdit(){

		// if ( Session::token() !== Input::get( '_token' ) ) {
  //           return Response::json( array(
  //               'msg' => 'Unauthorized attempt to create setting'
  //           ) );
  //       }

        $league = Input::get('league');
		$game = Input::get('game');
		$min = Input::get('min');

		$settings = Settings::firstOrNew(array('game_type_id' => $game, 'league_details_id' => $league, 'user_id' => Auth::user()->id));
		$settings->min_start = $min;
		$settings->ignore = 0;
		$settings->save();
		$today = date('Y-m-d', time());
		$matches = DB::table('series')
				->join('match', 'match.id', '=', 'series.end_match_id')
				->where('matchDate', '>=', $today)
				->where('active', '=', 1)
				->where('game_type_id', '=', $settings->game_type_id)
				->where('series.league_details_id', '=', $settings->league_details_id)
				->where('current_length', '>', $settings->min_start)//->get();
	 			->select('end_match_id', 'current_length')->get();
		foreach ($matches as $match) {
			$played = Played::where('game_type_id', '=', $settings->game_type_id)
				->where('match_id', '=', $match->end_match_id)
				->where('settings_id', '=', $settings->id)
				->count();
			if($played == 0 || $played == '0') {
				$pl = new Played;
				$pl->settings_id =$settings->id;
				$pl->game_type_id = $settings->game_type_id;
				$pl->match_id = $match->end_match_id;
				$pl->current_length = $match->current_length;
				$pl->save();
				//return $pl;	

			}

		}
		// $response = array(
  //           'status' => 'success',
  //           'msg' => 'Setting created successfully',
  //       );
 
    }

	public function deleteIgnore(){

		$league = Input::get('league');
		$game = Input::get('game');
		$min = Input::get('min');

		$settings = Settings::firstOrNew(array('game_type_id' => $game, 'league_details_id' => $league, 'user_id' => Auth::user()->id));
		$settings->min_start = $min;
		$settings->ignore = 1;
		$settings->save();

        return $league."/".$game."/".$min;	

	}
}