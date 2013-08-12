<?php

class RequestController extends BaseController {

	public function index() {
		return View::make('standard')
			-> with('title', 'Request')
			-> nest('content', 'pages.request');
	}

	public function submit() {

		if (Cache::get('request-' . Request::getClientIp())) {
			return View::make('standard')->
					with('title', 'Request')->
					nest('content', 'pages.request', array('error' => 'You may not submit more than one request per hour.'));	
		}

		$input = Input::all();
		$validator = Validator::make($input, array(
			'name' => 'required|unique:hosts|between:3,50',
			'website' => 'url',
			'mcf_url'  => 'url'
		));
		if ($validator->fails()) {
			$messages = $validator->messages();
			$out = '';
			foreach ($messages->all() as $message) {
				$out .= $message . ' ';
			}
		
			return View::make('standard')->
				with('title', 'Request')->
				nest('content', 'pages.request', array('error' => $out));

		}
		$request = new ReviewRequest();
		$request->name = Input::get('name');
		$request->mcf_url = Input::get('mcf_url');
		$request->website = Input::get('website');
		$request->rep = Input::get('rep') ? 1 : 0;
		$request->ip = Request::getClientIp();
		$request->save();

		Cache::put('request-' . $request->ip, 1, 60);

		return View::make('standard')->
				with('title', 'Request')->
				nest('content', 'pages.request', array('error' => 'Request Added!'));
	}

}