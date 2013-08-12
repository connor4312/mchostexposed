<?php

class AdminHostController extends BaseController {
	
	public function showHost($slug = null) {
		$criteria = DB::table('criteria')->
			orderBy('name')->
			orderBy('score')->
			select('name', 'value', 'score', 'id')->
			get();

		$host_criteria = array();
		$notes = array();

		if ($slug) {
			$host = Host::find($slug);
			$params['name'] = $host->name;
			$params['slug'] = $host->slug;
			$params['website'] = $host->website;
			$params['mcf_url'] = $host->mcf_url;
			$params['mcf_usernames'] = $host->mcf_usernames;
			$params['paypal_email'] = $host->paypal_email;
			$params['scored'] = $host->scored;

			$hc = DB::table('criteria_linkings')
				->where('host_id', '=', $host->id)
				->select('criteria_id')
				->get();

			foreach ($hc as $h) {
				$host_criteria[] = $h->criteria_id;
			}

			$notes = $host->notes;
		} else {
			$params['name'] = Input::get('name');
			$params['slug'] = Input::get('slug');
			$params['website'] = Input::get('website');
			$params['mcf_url'] = Input::get('mcf_url');
			$params['mcf_usernames'] = Input::get('mcf_usernames');
			$params['paypal_email'] = Input::get('paypal_email');
			$params['scored'] = Input::get('scored');
		}
		
		return View::make('standard')
		-> with('title', 'Manage Host')
		-> nest('content', 'admin.hosts', array(
			'criteria' => $criteria,
			'edit' => $slug,
			'host_criteria' => $host_criteria,
			'notes' => $notes,
			'params' => $params
		));
	}

	public function addHostSubmit() {
		$host = null;
		if (Input::get('edit')) {
			$host = Host::where('slug', '=', Input::get('edit'))->first();
		}
		if (!$host) {
			$host = new Host;
		}
		$host->name = htmlspecialchars(Input::get('name'));
		$host->slug = Input::get('slug');
		$host->scored = Input::get('scored') ? 1 : 0;
		$host->mcf_url = Input::get('mcf_url');
		$host->mcf_usernames = Input::get('mcf_usernames');
		$host->website = Input::get('website');
		$host->paypal_email = Input::get('paypal_email');
		$host->save();

		$host = Host::where('slug', '=', Input::get('slug'))->first();

		$existing_criteria_data = DB::table('criteria_linkings')->
			where('host_id', '=', $host->id)->
			select('criteria_id')->
			get();

		$existing_criteria = array();
		foreach ($existing_criteria_data as $link) {
			$existing_criteria[] = $link->criteria_id;
		}

		$in = array();
		foreach (Input::get('criteria') as $crit) {
			if ($crit != 'null' && !in_array($crit, $existing_criteria)) {
				$in[] = array(
					'host_id' => $host->id,
					'criteria_id' => $crit
				);
			}
		}
		DB::table('criteria_linkings')->insert($in);

		foreach (array_diff($existing_criteria, Input::get('criteria')) as $diff) {
			DB::table('criteria_linkings')->
				where('host_id', '=', $host->id)->
				where('criteria_id', '=', $diff)->
				delete();
		}

		DB::table('additionalnotes')->
			where('host_id', '=', $host->id)->
			delete();
		for ($i = 0; $i < count(Input::get('note_score')); $i++) {
			if (strlen(Input::get('note_comment')[$i]) > 3) {
				$note = new AdditionalNote;
				$note->host_id = $host->id;
				$note->description = Input::get('note_description')[$i];
				$note->comment = Input::get('note_comment')[$i];
				$note->score = Input::get('note_score')[$i];
				$note->save();
			}
		}


		return Redirect::to('/host/' . $host->slug);
	}
}