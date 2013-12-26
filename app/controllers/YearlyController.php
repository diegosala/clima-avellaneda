<?php

class YearlyController extends BaseController {
	protected $layout = 'layouts.archive';
	private $datepicker_format = "yyyy";

	public function main()
	{
		$min_date = Year::min('id');
                $max_date = Year::max('id');

                $view = View::make('archive.yearly.main');
                $view->with('year', 0);
                $view->with('yearly_section', true);
                $view->with('min_date', $min_date);
                $view->with('max_date', $max_date);
                $view->with('datepicker_format', $this->datepicker_format);		

		$this->layout->content = $view;
		$this->layout->with('yearly_section', true);
	}

	public function yearly($year)
	{	
		$year = Year::find($year);
		$this->layout->content = View::make('archive.yearly.main')->with('year', $year)->with('yearly_section', true);
		$this->layout->with('yearly_section', true);
	}
}
