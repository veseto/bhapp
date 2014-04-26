<?php

class MatchController extends BaseController {

	public function showWelcome($country, $leagueName, $season)	{
		
		return View::make('stats');
	
	}

	public function getStats($country, $leagueName, $season) {
		
		$leagueId = LeagueDetails::getId($country, $leagueName);
		
		$distResults = $this->getUniqueResults(Match::matchesForSeason($leagueId, $season));

		$allCount = Match::matchesForSeason($leagueId, $season)->count();
		$drawCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'D')->count();
		$homeCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'H')->count();
		$awayCount = Match::matchesForSeason($leagueId, $season)->where('resultShort', '=', 'A')->count();


		$array = array('leagueName' => $leagueName, 
						'country' => $country,
						'season' => $season,
						'all' => $allCount, 
						'draw' => $drawCount, 
						'home' => $homeCount,
						'away' => $awayCount,
						'distResults' => $distResults);

		return View::make('stats')->with('stats', $array);
	
	}

	private function getUniqueResults($matches) {

		//return $results = Match::groupBy('homeGoals', 'awayGoals')->get(array('homeGoals', 'awayGoals', DB::raw('count(*) as count'));
		return $matches->select('homeGoals', 'awayGoals', DB::raw('count(*) as total'))
                 ->groupBy('homeGoals', 'awayGoals')
                 ->get();
	}

}
