<?php

class DailyController extends BaseController {
	protected $layout = 'layouts.archive';

	public function main()
	{
		$this->layout->content = View::make('archive.daily.main')->with('day', 0)->with('daily_section', true);
		$this->layout->with('daily_section', true);
	}

	public function daily($year, $month, $day)
	{
		$day = Day::where('date', '=', "{$year}-{$month}-{$day}")->get()->first();
		$this->layout->content = View::make('archive.daily.main')->with('day', $day)->with('daily_section', true);
		$this->layout->with('daily_section', true);
	}
}
