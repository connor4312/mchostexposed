<?php

class HostController extends BaseController {

	public function index($slug, $error = null) {

		$host = Host::find($slug);

		if (is_null($host)) {
			return App::abort(404);
		}
		$criteria = DB::table('criteria_linkings')
			-> select('criteria.name', 'criteria.value', 'criteria.score')
			-> where('criteria_linkings.host_id', $host->id)
			-> join('criteria', 'criteria_linkings.criteria_id', '=', 'criteria.id')
			-> orderBy('criteria.name', 'asc')
			-> get();

		$bsrating = 0;
		foreach ($criteria as $rating) {
			$bsrating += $rating->score;
		}

		$notes = DB::table('additionalnotes')->
			select('description', 'score', 'comment')->
			where('host_id', '=', $host->id)->
			get();

		foreach ($notes as $note) {
			$bsrating += $note->score;
		}

		return View::make('standard')
		-> with('title', $host->name)
		-> with('footer_scripts', array('js/bootstrap.min.js', 'js/host.js'))
		-> with('addendum', 'pages.host_addendum')
		-> with('host', $host)
		-> nest('content', 'pages.host', array(
				'host' => $host,
				'ratings' => $criteria,
				'bsrating' => max($bsrating, 0),
				'notes' => $notes,
				'error' => $error
			));
	}

	public function breakdown($slug) {

		$host = Host::find($slug);

		if (is_null($host) || !Request::ajax()) {
			return App::abort(404);
		}


		$criteria = DB::table('criteria_linkings')
			-> select('criteria.name', 'criteria.value', 'criteria.score', 'criteria_descriptions.description')
			-> where('criteria_linkings.host_id', $host->id)
			-> join('criteria', 'criteria_linkings.criteria_id', '=', 'criteria.id')
			-> leftjoin('criteria_descriptions', 'criteria.name', '=', 'criteria_descriptions.criteria_name')
			-> orderBy('criteria.name', 'asc')
			-> get();

		$notes = DB::table('additionalnotes')->
			select('description', 'score', 'comment')->
			where('host_id', '=', $host->id)->
			get();

		return View::make('pages.host_breakdown', array(
			'host' => $host,
			'ratings' => $criteria,
			'notes' => $notes
		));
	}

	public function reportForm($slug) {

		$host = Host::find($slug);

		if (is_null($host) || !Request::ajax()) {
			return App::abort(404);
		}

		$criteria = DB::table('criteria_linkings')
			-> select('criteria.name', 'criteria.value', 'criteria_linkings.id')
			-> where('criteria_linkings.host_id', $host->id)
			-> join('criteria', 'criteria_linkings.criteria_id', '=', 'criteria.id')
			-> orderBy('criteria.name', 'asc')
			-> get();

		return View::make('pages.host_correction', array(
			'host' => $host,
			'criteria' => $criteria
		));
	}

	public function reportSubmit($slug) {

		if (Cache::get('request-' . Request::getClientIp())) {
			return $this->index($slug, 'You may not submit more than one request per hour.');
		}

		$host = Host::find($slug);

		if (is_null($host)) {
			return App::abort(404);
		}

		$input = Input::all();
		$validator = Validator::make($input, array(
			'criteria_linkid' => 'required|numeric|exists:criteria_linkings,id',
			'should_be' => 'required|between:2,50'
		));
		if ($validator->fails()) {
			$messages = $validator->messages();
			$out = '';
			foreach ($messages->all() as $message) {
				$out .= $message . ' ';
			}
		
			return $this->index($slug, $out);

		}

		$correction = new CorrectionRequest();
		$correction->host_id = $host->id;
		$correction->criteria_id = Input::get('criteria_linkid');
		$correction->should_be = Input::get('should_be');
		$correction->ip = Request::getClientIp();
		$correction->save();

		Cache::put('request-' . $correction->ip, 1, 60);

		return $this->index($slug, 'Correction submitted, it will be reviewed soon.');

	}

}