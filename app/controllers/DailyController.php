<?php

class DailyController extends BaseController {
	protected $layout = 'layouts.archive';
	private $datepicker_format = 'yyyy/mm/dd';	

	public function main()
	{
		$min_date = Day::min('date');
		$max_date = Day::max('date');

		$view = View::make('archive.daily.main');
		$view-> with('day', 0);
		$view->with('daily_section', true);
		$view->with('min_date', str_replace('-', '/', $min_date));
		$view->with('max_date', str_replace('-', '/', $max_date));
		$view->with('datepicker_format', $this->datepicker_format);

		$this->layout->content = $view;
		$this->layout->with('daily_section', true);
	}

	public function daily($year, $month, $day)
	{
		$day = Day::where('date', '=', "{$year}-{$month}-{$day}")->get()->first();
		$this->layout->content = View::make('archive.daily.main')->with('day', $day)->with('daily_section', true);
		$this->layout->with('daily_section', true);
	}
}
