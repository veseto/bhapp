<?php

class BaseController extends Controller {
	public function __construct() {
		$global = CommonPools::where('user_id', '=', Auth::user()->id)->first();
	    View::share('global', $global);	
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{

			$this->layout = View::make($this->layout);
	    }
	}

}