<?php

class LeagueDetailsController extends BaseController {

	public function getImportedSeasons($country, $league) {
		
		$seasons = LeagueDetails::where('country', '=', $country)->where('fullName', '=', $league)->first()->importedSeasons;
		$data = array('seasons' => $seasons, 'country' => $country, 'league' => $league);

		return View::make('seasons')->with('data', $data);
	}

	public function getLeaguesForCountry($country) {
		$leagues = LeagueDetails::where('country', '=', $country)->get();
	    $arr = array('leagues' => $leagues, 'country' => $country);

	    return View::make('leagues')->with('data', $arr);
	}

	public function getCountriesPlusLeagues() {
		$countries = LeagueDetails::distinct()->get(array('country'));

		$data = array();
		foreach ($countries as $country) {
			$leagues = LeagueDetails::where('country', '=', $country->country)->get(array('fullName'));
			$names = array();
			foreach ($leagues as $league) {
				array_push($names, $league->fullName);
			}
			$data[$country->country] = $names;
		}
    	return View::make('countries')->with('data', $data);
	}
}