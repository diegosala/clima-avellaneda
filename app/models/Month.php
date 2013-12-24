<?php
class Month extends Eloquent {
	public function days() {
		return $this->hasMany("Day");
	}	

	public function year() {
		return $this->belongsTo("Year");
	}
	
	public function windDirection() {
                return $this->belongsTo("WindDirection", "wind_direction");
        }
}
