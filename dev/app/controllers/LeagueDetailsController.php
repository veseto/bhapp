<?php

class LeagueDetailsController extends BaseController {

	public function getImportedSeasons($country, $leagueName) {
		
		$seasons = LeagueDetails::where('country', '=', $country)->where('fullName', '=', $leagueName)->first()->importedSeasons;
		$data = array('seasons' => $seasons, 'country' => $country, 'league' => $leagueName);

		return View::make('seasons')->with('data', $data);
	}

}