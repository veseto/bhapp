<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class ImportedSeasons extends Eloquent {
	protected $table = 'importedSeasons';

    public $timestamps = false;

    public static getImportedSeasons($country, $leagueName) {
    	$leagueId = DB::table('leagueDetails')->where('country', '=', $country)->where('fullName', '=', $leagueName)->pluck('leagueId');
    	return ImportedSeasons::where('leagueId', '=', $leagueId);
    }
}

