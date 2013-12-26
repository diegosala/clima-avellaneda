<?php

class YearlyController extends ArchiveController{
	public function main()
	{
                $view = View::make('archive.yearly.main');
                $view->with('year', 0);
                $view->with('yearly_section', true);                	

                $this->layout->content = $this->setUpDatePicker($view);
                $this->layout->with('yearly_section', true);
	}

	public function yearly($year)
	{	
		$year = Year::find($year);
		$this->layout->content = $this->setUpDatePicker(View::make('archive.yearly.main')->with('year', $year)->with('yearly_section', true), "{$year}");
		$this->layout->with('yearly_section', true);
	}

	protected function getDatePickerFormat() {
                return 'yyyy';
       }
}
