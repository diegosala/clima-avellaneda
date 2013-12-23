<?php
class Day extends Eloquent {
	public function archives() {
		return $this->hasMany("Archive");
	}

	public function month() {
		return $this->belongsTo("Month");
	}	
}
