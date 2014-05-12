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

Route::get('/drawstats/{country}/{league}', 'SeriesController@percentStat');
Route::get('/drawspercent', 'SeriesController@percentDraws');
Route::get('/roundpercent/{country}/{league}', 'SeriesController@percentDrawsPerRound');

Route::get('/simulator/{country}/{league}', 'SimulatorController@getSimMatches');
Route::post('/simulator', 'SimulatorController@newSim');

// Route::get('/simusa/{startdate?}/{enddate?}', 'MatchController@getSimMatchesusa')-> before('auth');

// Route::post('/simusa', 'MatchController@newSimusa');
// Route::post('/nextusa', 'MatchController@nextusa');


Route::get('/bsim/{season?}/{round?}', 'MatchController@getSimMatches')-> before('auth');
Route::post('/save', 'MatchController@save')-> before('auth');
// Route::get('/simstart', 'MatchController@startSim')-> before('auth');
Route::post('/bsim', 'MatchController@newSim');
Route::post('/next', 'MatchController@next');
Route::get('/sim/{season?}/{round?}', 'MatchController@getSimMatches2')-> before('auth');
Route::get('/simstart', 'MatchController@startSim')-> before('auth');
Route::post('/sim', 'MatchController@newSim2');
Route::post('/next2', 'MatchController@next2');

Route::get('/calculateseries/{country}', "SeriesController@calculatePPSSeries");
Route::get('/calculateseries/{country}/{team}', "SeriesController@calculatePPSSeriesForTeam");
Route::get('/updateseries', "SeriesController@updateAllPPSSeries");

Route::get('/calculateseriesppm', "SeriesController@calculatePPMSeries");

Route::get('/show', "SeriesController@getSeries");
// Route::get('/hello', "HomeController@show");

Route::get('login', 'SessionsController@create');

Route::get('logout', 'SessionsController@destroy');

Route::resource('sessions', 'SessionsController', ['only'  => ['create', 'store', 'destroy']]);

Route::get('/settings', 'SettingsController@display')-> before('auth');

Route::post('/settings/enable', "SettingsController@createEdit");

Route::post('/settings/disable', "SettingsController@deleteIgnore");

// Route::get('hello', function()
// {
// 	$m = Match::find('000cQmf2');
// 	$data['team'] = '';
// 	$data['match'] = $m;
// 	return View::make('hello')->with('data', $data);
// })-> before('auth');

Route::get('/home/{from?}/{to?}', array('as' => 'matches', 'uses' => 'MatchController@getMatches'))-> before('auth');
Route::get('/', array('as' => 'matches', 'uses' => 'MatchController@getMatches'))-> before('auth');

Route::get('/matches/{from?}/{to?}', 'MatchController@getMatches')-> before('auth');
// Route::get('/simstart', 'MatchController@startSim')-> before('auth');

Route::get('countries', array('as' => 'countries', 'uses' => 'LeagueDetailsController@getCountriesPlusLeagues'))-> before('auth');

// View::composer('layouts.partials.square', 'SquareComposer');
// View::composer('layouts.partials.square', function($view) {			
//   	$view->with('data', $data);
// });

Route::get('{country}', array('as' => 'country', 'uses' => 'LeagueDetailsController@getLeaguesForCountry'))-> before('auth');

Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"))-> before('auth');

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"))-> before('auth');
