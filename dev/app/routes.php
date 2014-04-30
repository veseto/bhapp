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

Route::get('/home', function()
{
	return View::make('home');
});

Route::get('matches', array('as' => 'matches', 'uses' => 'MatchController@getTodaysMatches'));
Route::get('api/matches', array('as'=>'api.matches', 'uses'=>'MatchController@getDatatable'));


Route::get('countries', array('as' => 'countries', 'uses' => 'LeagueDetailsController@getCountriesPlusLeagues'));

Route::get('{country}', array('as' => 'country', 'uses' => 'LeagueDetailsController@getLeaguesForCountry'));

Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"));

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"));
