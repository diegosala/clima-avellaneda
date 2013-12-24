<?php

class MonthlyController extends BaseController {
	protected $layout = 'layouts.archive';

	public function main()
	{
		$this->layout->content = View::make('archive.monthly.main')->with('month', 0)->with('monthly_section', true);
		$this->layout->with('monthly_section', true);
	}

	public function monthly($year, $month)
	{	
		$month = Month::where('month', '=', $month)->where('year_id', '=', $year)->get()->first();
		$this->layout->content = View::make('archive.monthly.main')->with('month', $month)->with('monthly_section', true);
		$this->layout->with('monthly_section', true);
	}
}
