<?php

class ListController extends BaseController {

	public function index() {
		
		$arr = explode('-', Input::get('order'));
		if (!isset($arr[0]) || (!$arr[0] == 'thescore' && !$arr[0] == 'created_at')) {
			$arr[0] = 'thescore';
		}
		if (!isset($arr[1]) || (!$arr[1] == 'asc' && !$arr[1] == 'desc')) {
			$arr[1] = 'asc';
		}

		$hosts = DB::table('hosts')->
			select('hosts.name', 'hosts.scored', 'hosts.slug', DB::raw('(COALESCE(SUM(`hex_criteria`.`score`), 0) + COALESCE(notes.score, 0)) as thescore'))->
			leftjoin('criteria_linkings', 'hosts.id', '=', 'criteria_linkings.host_id')->
			leftjoin('criteria', 'criteria_linkings.criteria_id', '=', 'criteria.id')->
			leftjoin(DB::raw('(SELECT SUM(`score`) as score, `host_id` FROM `hex_additionalnotes` GROUP BY `host_id`) notes'), DB::raw('notes.`host_id`'), '=', 'hosts.id');
		if (Input::get('credits')) {
			die('Made by Connor Peet <connor4312>');
		}
		if (Input::get('criteria')) {
			$getcriteria = explode('-', Input::get('criteria'));
			
			$inner = '';
			$outer = '';

			foreach ($getcriteria as $c) {
				$c = preg_replace('/[^0-9]/', '', $c);
				if (!$c) {
					continue;
				}
				$inner .= '`criteria_id` = "' . $c . '" OR';
				$outer .= $c . ',';
			}
			$inner = rtrim($inner, ' OR');
			$outer = rtrim($outer, ',');

			$critters = DB::select(DB::raw('SELECT `host_id` FROM
				(
					select `host_id`, GROUP_CONCAT(`criteria_id`) as con
					from `hex_criteria_linkings`
					WHERE (' . $inner . ')
					GROUP BY `host_id`
				) tab WHERE con = "' . $outer . '"'));

			if (count($critters) == 1) {
				return Redirect::to('/host/' . Host::where('id', '=', $critters[0]->host_id)->first()->slug);
			} elseif (count($critters) > 1) {

				$hosts = $hosts->where(function($query) use ($critters) {
					$query->where('hosts.id', '=', $critters[0]->host_id);
					for ($i = 1; $i < count($critters); $i++) {
						$query->orWhere('hosts.id', '=', $critters[$i]->host_id);
					}
				});

			} else {
				$hosts = $hosts->whereRaw('1 = 0');
			}
		}

		$hosts = $hosts->
			orderBy('scored', 'DESC')->
			orderBy($arr[0], $arr[1])->
			groupBy('hosts.id')->
			paginate(12);

		$criteria = DB::table('criteria')->
			orderBy('name', 'ASC')->
			orderBy('score', 'DESC')->
			where('visible', '=', '1')->
			get();
			
		$crits = explode('-', Input::get('criteria'));

		return View::make('standard')->
			with('title', 'Listing')->
			with('footer_scripts', array('js/jquery.autocomplete.js', 'js/listing.js'))->
			nest('content', 'pages.list', array(
				'hosts' => $hosts,
				'criteria' => $criteria,
				'crits' => $crits
			));

	}

	public function autoComplete() {
		if (strlen(Input::get('query')) < 2) {
			return App::abort(400);
		}
		$hosts = DB::table('hosts')->
			select('slug', 'name')->
			where(DB::raw('LOWER(name)'), 'LIKE', strtolower(Input::get('query')) . '%')->
			take(10)->
			get();

		if (Request::ajax()) {
			$out = array('suggestions' => array());

			foreach ($hosts as $host) {
				$out['suggestions'][] = array(
						'value' => $host->name,
						'data' => $host->slug
					);
			}
			return Response::json($out, 200);
		} else {
			return Redirect::to('/host/' . $hosts[0]->slug);
		}
	}

}