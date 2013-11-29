<?php
class Day extends Eloquent {
	public function archives() {
		return $this->hasMany("Archive");
	}

	public function month() {
		return $this->belongsTo("Month");
	}
	
	public function addArchive($archive) {
		if($archive->temperature > $this->max_temperature) {
			$this->max_temperature = $archive->temperature;
			$this->max_temperaure_time = '2013-11-29 00:00:00';
		}
		$this->save();
		$this->archives()->save($archive);
	}	
}
