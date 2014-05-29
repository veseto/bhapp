<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//stats
// Route::get('/boo', function(){
// 	$date = date('Y-m-d');
// 	$gr = Groups::find(3);
// 	Parser::parseMatchesForGroup($gr);
// 	Parser::parseLeagueSeries($gr);
	
// 	$from = 2;
// 	$to = 6;
// 	$teams = array();
// 	for($i = 0; $i < 100; $i ++) {
// 		$count = Standings::where('league_details_id', '=', $gr->league_details_id)
// 				->where('streak', '>=', $i);
// 		if ($count->count() <= $to){
// 			if ($count->count() < $from) {
// 				$teams = Standings::where('league_details_id', '=', $gr->league_details_id)
// 				->where('streak', '>=', $i - 1)->lists('team');

// 				break 1;
// 			} else { 
// 				$teams = Standings::where('league_details_id', '=', $gr->league_details_id)
// 				->where('streak', '>=', $i)->lists('team');

// 			}
// 			break 1;
// 		} 
// 	}

// 	// return $teams;
// 	return $gr->matches()->where(function ($query) use ($teams) {
//              $query->whereIn('home', $teams)
//                    ->orWhereIn('away', $teams);
//        })->get();
// });

// addGamesForUser parseLeagueSeries
// Route::get('/boo', 'GamesController@addGamesForUser');
// Route::get('/boo', '');
Route::get('/boo', function(){
	// $league_details_id = 104;
	// $matches = Match::where('league_details_id', '=', $league_details_id)->get();
	// foreach ($matches as $m) {
	// 	Updater::updateDetails($m);
	// }
	return Updater::update();
});
// Route::get('/boo', function(){
// 	Parser::parseLeagueSeries(Groups::find(6));
// });
Route::post('/pools/get', 'PoolsController@getFromMain');
Route::get('/group/{id}', 'GroupController@getGamesForGroup');


Route::get('/nextmatches/{country}/{league}', 'MatchController@getNextMatchesForPlay');

Route::get('/drawstats/{country}/{league}', 'SeriesController@percentStat');
Route::get('/drawspercent', 'SeriesController@percentDraws');
Route::get('/roundpercent/{country}/{league}', 'SeriesController@percentDrawsPerRound');

Route::get('/simulator/{country?}/{league?}/{seasoncount?}', 'SimulatorController@getSimMatches');
Route::post('/simulator/{country?}/{league?}/{seasoncount?}', 'SimulatorController@newSim');

Route::get('/simulatorfix/{country?}/{league?}/{seasoncount?}', 'SimulatorController@getSimMatchesFix');
Route::post('/simulatorfix/{country?}/{league?}/{seasoncount?}', 'SimulatorController@newSimFix');

Route::get('/calculateseries/{country}', "SeriesController@calculatePPSSeries");
Route::get('/calculateseries/{country}/{team}', "SeriesController@calculatePPSSeriesForTeam");
Route::get('/updateseries', "SeriesController@updateAllPPSSeries");

Route::get('/calculateseriesppm', "SeriesController@calculatePPMSeries");

Route::get('/show', "SeriesController@getSeries");

Route::get('login', 'SessionsController@create');

Route::get('logout', 'SessionsController@destroy');

Route::resource('sessions', 'SessionsController', ['only'  => ['create', 'store', 'destroy']]);

Route::get('/settings', 'SettingsController@display');

Route::post('/settings/enable', "SettingsController@createEdit");

Route::post('/settings/disable', "SettingsController@deleteIgnore");


Route::get('/home/{from?}/{to?}', array('as' => 'matches', 'uses' => 'GamesController@getGroups'));
Route::get('/', array('as' => 'matches', 'uses' => 'GamesController@getGroups'));

Route::get('/matches/{from?}/{to?}', 'MatchController@getMatches');

Route::get('countries', array('as' => 'countries', 'uses' => 'LeagueDetailsController@getCountriesPlusLeagues'));


Route::get('{country}', array('as' => 'country', 'uses' => 'LeagueDetailsController@getLeaguesForCountry'));

Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"));

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"));
