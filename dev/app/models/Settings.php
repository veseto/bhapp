<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Settings extends Eloquent {
    protected $table = 'settings';

    public $timestamps = false;

    public $fillable = array('game_type_id', 'league_details_id', 'user_id', 'min_start', 'ignore');
    
}

