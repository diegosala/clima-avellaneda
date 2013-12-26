<?php

class MonthlyController extends BaseController {
	protected $layout = 'layouts.archive';
	private $datepicker_format = "yyyy/mm";

	public function main()
	{	

		$min_date = Month::min(DB::raw('year_id * 100 + month'));
                $max_date = Month::max(DB::raw('year_id * 100 + month'));

                $view = View::make('archive.monthly.main');
                $view->with('month', 0);
                $view->with('monthly_section', true);
                $view->with('min_date', str_replace('-', '/', $min_date));
                $view->with('max_date', str_replace('-', '/', $max_date));
                $view->with('datepicker_format', $this->datepicker_format);

		$this->layout->content = $view;
		$this->layout->with('monthly_section', true);
	}

	public function monthly($year, $month)
	{	
		$month = Month::where('month', '=', $month)->where('year_id', '=', $year)->get()->first();
		$this->layout->content = View::make('archive.monthly.main')->with('month', $month)->with('monthly_section', true);
		$this->layout->with('monthly_section', true);
	}
}
