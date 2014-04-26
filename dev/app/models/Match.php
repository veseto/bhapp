<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Match extends Eloquent {
    protected $table = 'match';

    public $timestamps = false;

    public static function matchesForSeason($leagueId, $season) {

    	return Match::where('league_details_id', '=', $leagueId)->where('season', '=', $season);

    }
}

