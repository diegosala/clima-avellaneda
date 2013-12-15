<?php
class Year extends Eloquent {
	public function months() {
		return $this->hasMany("Month");
	}
}
