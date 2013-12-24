<?php
class Year extends Eloquent {
	public function months() {
		return $this->hasMany("Month");
	}

	public function windDirection() {
		return $this->belongsTo("WindDirection", "wind_direction");
	}
}
