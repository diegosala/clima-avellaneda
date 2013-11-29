<?php
class Archive extends Eloquent {
	protected $table = "archive";
	public function day() {
		return $this->belongsTo("Day");
	}
}
