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

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('countries', function()
{
    $countries = LeagueDetails::distinct()->get(array('country'));

    return View::make('countries')->with('countries', $countries);
});

Route::get('{country}', function($country)
{
    $leagues = LeagueDetails::where('country', '=', $country)->get();

    return View::make('leagues')->with('leagues', $leagues);
});

Route::get('{country}/{league}', function($country, $league)
{
    return View::make('seasons')->with('seasons', $leagueId->leagueId);
});