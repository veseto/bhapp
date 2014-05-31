<?php

class PoolsController extends \BaseController {

	public function getFromMain() {
		$league_details_id = Input::get('league');
		$amount = Input::get('amount');
		$common = User::find(Auth::user()->id)->common_pools()->first();
		$common->amount = $common->amount - $amount;
		$common->save();
		$pool = User::find(Auth::user()->id)->pools()->where('league_details_id', '=', $league_details_id)->first();
		$pool->amount = $pool->amount + $amount;
		$pool->current = $pool->amount;
		$pool->save();

		$settings = Settings::where('user_id', '=', Auth::user()->id)->where('league_details_id', '=', $league_details_id)->first();

		$gr = Groups::where('league_details_id', '=', $league_details_id)->where('state', '=', 2)->get(['id'])[0]->id;

		Updater::recalculateGroup($gr, Auth::user()->id);

		return Redirect::back();
	}

	public function managePools(){
		return View::make('poolmanagement');
	}

	public function pushToMain($league_details_id, $user_id, $amount) {
		$pool = Pool::where('user_id', '=', $user_id)->where('league_details_id', '=', $league_details_id)->get();
		$pool->amount = $pool->amount - $amount;
		$pool->save;
		$common->amount = $common->amount + $amount;
		$common->save;
		$groups_id = Groups::where('league_details_id', '=', $league_details_id)->where('state', '=', 2)->first(['id']);
		Updater::recalculateGroup($groups_id->id, $user_id);
	}

	public function pullFromMain($league_details_id, $user_id, $amount) {
		$pool = Pool::where('user_id', '=', $user_id)->where('league_details_id', '=', $league_details_id)->get();
		$pool->amount = $pool->amount + $amount;
		$pool->save;
		$common->amount = $common->amount - $amount;
		$common->save;
		$groups_id = Groups::where('league_details_id', '=', $league_details_id)->where('state', '=', 2)->first(['id']);
		Updater::recalculateGroup($groups_id->id, $user_id);
	}
}
