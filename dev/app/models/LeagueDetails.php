<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class LeagueDetails extends Eloquent {
	protected $table = 'leagueDetails';

    public $timestamps = false;

    public function importedSeasons(){

    	return $this->hasMany("ImportedSeasons");
    
    }

    public static function getId($country, $leagueName) {

    	$leagueDetails = LeagueDetails::where('country', '=', $country)->where('fullName', '=', $leagueName)->first();
    	
    	return $leagueDetails->id; 
    }
}

