<?php

class AdminController extends BaseController {

	public function index() {
		//$correction_reqs = CorrectionRequest::orderBy('created_at', 'ASC')->take(50)->get();
		$correction_reqs = DB::table('corrections')
		-> select('corrections.*', 'hosts.name AS host_name')
		-> join('hosts', 'corrections.host_id', '=', 'hosts.id')
		-> take(50) -> get();

		$review_reqs = ReviewRequest::orderBy('created_at', 'ASC')->take(50)->get();
		$hosts = Host::orderBy('created_at')->take(10)->get();

		return View::make('standard')
		-> with('title', 'Admin Home')
		-> with('footer_scripts', array('js/bootstrap.min.js', 'js/host.js'))
		-> with('addendum', 'admin.home_addendum')
		-> nest('content', 'admin.home', array(
			'correction_reqs' => $correction_reqs,
			'review_reqs' => $review_reqs,
			'hosts' => $hosts
		));
	}

	public function login() {
		if (Session::get('logged_id')) {
			return Redirect::to('/admincp');
		}

		return View::make('standard')
		-> with('title', 'Admin Login')
		-> nest('content', 'admin.login');
	}

	public function doLogin() {
		$pass = Input::get('password');
		if ($pass == 'p^;[7s55)[^C/.5,!95Q') {
			Session::put('logged_in', 1);
			return Redirect::to('/admincp');
		} else {
			sleep(5);
			App::abort(503);
		}
	}

	public function showCorrectionRequest($id) {
		return View::make('standard')
		-> with('title', 'Correction Request')
		-> with('content', '');
	}

	public function showReviewRequest($id) {
		return View::make('standard')
		-> with('title', 'Review Request')
		-> with('content', '');
	}

}