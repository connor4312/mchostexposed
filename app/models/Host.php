<?php

class Host extends Eloquent {

	protected $table = 'hosts';
	protected $primaryKey = 'slug';

	public function linking() {
		return $this->hasMany('CriteriaLinking');
	}

	public function notes() {
		return $this->hasMany('AdditionalNote');
	}

}