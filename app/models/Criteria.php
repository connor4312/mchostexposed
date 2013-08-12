<?php

class Criteria extends Eloquent {

	protected $table = 'criteria';

	public function linking() {
		return $this->hasMany('criteria_linking');
	}
}