<?php

class SettingsController extends BaseController {

	public function display() {
		// $settings = Settings::where('user_id', '=', Auth::user()->id);

		$data = array();

		$league = LeagueDetails::orderBy('country')->get();
		
		foreach ($league as $l) {
			if (!array_key_exists($l->country, $data)) {
				$data[$l->country] = array();
			}
			if (!array_key_exists($l->fullName, $data[$l->country])) {
				$data[$l->country][$l->fullName] = array();
			}
			$data[$l->country][$l->fullName][0] = $l->id;
			$data[$l->country][$l->fullName][1] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 1)->where('user_id', '=', Auth::user()->id)->first();
			$data[$l->country][$l->fullName][2] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 2)->where('user_id', '=', Auth::user()->id)->first();
			$data[$l->country][$l->fullName][3] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 3)->where('user_id', '=', Auth::user()->id)->first();
			$data[$l->country][$l->fullName][4] = Settings::where('league_details_id', '=', $l->id)->where('game_type_id', '=', 4)->where('user_id', '=', Auth::user()->id)->first();
		}
		return View::make('settings')->with('settings', $data);
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
		// $response = array(
  //           'status' => 'success',
  //           'msg' => 'Setting created successfully',
  //       );
 
        return $league."/".$game."/".$min;	
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