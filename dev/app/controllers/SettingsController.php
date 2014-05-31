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

	// public function saveSettings($user_id, $league_details_id, $from, $to, $multiplier) {
	// 	$settings = Settings::firstOrNew('user_id' => $user_id, 'league_details_id' => $league_details_id, 'from' => $from, 'to' => $to, 'multiplier' => $multiplier);
	// 	$settings->save;
	// 	$pool = Pool::firstOrNew('user_id' => $user_id, 'league_details_id' => $league_details_id);
	// 	$pool->save;
	// 	$groups_id = Groups::where('league_details_id', '=', $league_details_id)->where('state', '=', 2)->first()->id;
	// 	Updater::recalculateGroup($groups_id, $user_id);
	// }

	// public function deleteSettings($user_id, $league_details_id) {
	// 	$settings = Settings::firstOrFail('user_id' => $user_id, 'league_details_id' => $league_details_id);
	// 	$settings->delete;
	// }	

}