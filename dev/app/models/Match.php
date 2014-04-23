<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Match extends Eloquent {
    protected $table = 'match';

    public $timestamps = false;
}

