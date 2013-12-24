<?php

class MonthlyController extends BaseController {
	protected $layout = 'layouts.archive';

	public function main()
	{
		$this->layout->content = View::make('archive.monthly.main')->with('month', 0)->with('monthly_section', true);
		$this->layout->with('monthly_section', true);
	}

	public function monthly($month, $year)
	{
		$this->layout->content = View::make('archive.monthly.main')->with('month', 1)->with('monthly_section', true);
		$this->layout->with('monthly_section', true);
	}
}
