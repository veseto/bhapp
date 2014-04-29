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

Route::get('countries', function()
{
    $countries = LeagueDetails::distinct()->get(array('country'));

    return View::make('countries')->with('countries', $countries);
});

Route::get('{country}', function($country)
{
    $leagues = LeagueDetails::where('country', '=', $country)->get();
    $arr = array('leagues' => $leagues, 'country' => $country);

    return View::make('leagues')->with('data', $arr);
});


Route::get('{country}/{league}/archive', array('as' => 'archive', 'uses' => "LeagueDetailsController@getImportedSeasons"));

Route::get('{country}/{league}/{season}/stats', array('as' => 'stats', 'uses' => "MatchController@getStats"));

Route::get('{country}/{league}/{season}/sequences', array('as' => 'sequences', 'uses' => "MatchController@getSequences"));