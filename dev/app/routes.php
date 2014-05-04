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

Route::get('/calculateseries', "SeriesController@calculatePPSSeries");

Route::get('/show', "SeriesController@getSeries");

Route::get('login', 'SessionsController@create');

Route::get('logout', 'SessionsController@destroy');

Route::resource('sessions', 'SessionsController', ['only'  => ['create', 'store', 'destroy']]);

Route::get('/settings', function()
{
	return View::make('settings');
})-> before('auth');

Route::get('/home', function()
{
	return View::make('home');
})-> before('auth');

Route::get('hello', function()
{
	$m = Match::find('000cQmf2');
	$data['team'] = '';
	$data['match'] = $m;
	return View::make('hello')->with('data', $data);
})-> before('auth');

Route::get('/matches', array('as' => 'matches', 'uses' => 'MatchController@getTodaysMatches'))-> before('auth');

Route::get('api/matches', array('as'=>'api.matches', 'uses'=>'MatchController@getDatatable'))-> before('auth');

Route::get('/matches2', array('as' => 'matches2', 'uses' => 'MatchController@getTodaysMatches2'))-> before('auth');

Route::get('api/matches2', array('as'=>'api.matches2', 'uses'=>'MatchController@getDatatable2'))-> before('auth');

Route::get('countries', array('as' => 'countries', 'uses' => 'LeagueDetailsController@getCountriesPlusLeagues'))-> before('auth');

// View::composer('layouts.partials.square', 'SquareComposer');
// View::composer('layouts.partials.square', function($view) {			
//   	$view->with('data', $data);
// });

Route::get('{country}', array('as' => 'country', 'uses' => 'LeagueDetailsController@getLeaguesForCountry'))-> before('auth');

Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"))-> before('auth');

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"))-> before('auth');
