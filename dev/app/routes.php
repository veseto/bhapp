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
Route::get('/boo', function(){
	$date = date('Y-m-d');
	return Groups::where('enddate', '<', $date)->get();
});

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


Route::get('/home/{from?}/{to?}', array('as' => 'matches', 'uses' => 'MatchController@getMatches'));
Route::get('/', array('as' => 'matches', 'uses' => 'MatchController@getMatches'));

Route::get('/matches/{from?}/{to?}', 'MatchController@getMatches');

Route::get('countries', array('as' => 'countries', 'uses' => 'LeagueDetailsController@getCountriesPlusLeagues'));


Route::get('{country}', array('as' => 'country', 'uses' => 'LeagueDetailsController@getLeaguesForCountry'));

Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"));

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"));
