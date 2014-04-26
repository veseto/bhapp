<?php

class LeagueDetailsController extends BaseController {

	public function getImportedSeasons($country, $leagueName) {
		
		$seasons = LeagueDetails::where('country', '=', $country)->where('fullName', '=', $leagueName)->first()->importedSeasons;

		return View::make('seasons')->with('seasons', $seasons);
	}

}