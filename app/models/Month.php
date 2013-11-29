<?php
class Month extends Eloquent {
	public function days() {
		return $this->hasMany("Day");
	}	

	public function year() {
		return $this->belongsTo("Year");
	}
}
