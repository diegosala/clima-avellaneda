<?php

class YearlyController extends BaseController {
	protected $layout = 'layouts.archive';

	public function main()
	{
		$this->layout->content = View::make('archive.yearly.main')->with('year', 0);
	}

	public function yearly($year)
	{	
		$year = Year::find($year);
		$this->layout->content = View::make('archive.yearly.main')->with('year', $year->id);
	}
}