<?php

class MonthlyController extends ArchiveController{
	public function main()
	{	
                $view = View::make('archive.monthly.main');
                $view->with('month', 0);
                $view->with('monthly_section', true);

                $this->layout->content = $this->setUpdatePicker($view);
                $this->layout->with('monthly_section', true);
	}

	public function monthly($year, $month)
	{	
		$monthData = Month::where('month', '=', $month)->where('year_id', '=', $year)->get()->first();
		$this->layout->content = $this->setUpdatePicker(View::make('archive.monthly.main')->with('month', $monthData)->with('monthly_section', true), "{$year}-{$month}");
		$this->layout->with('monthly_section', true);
	}
	
	protected function getDatePickerFormat($php = false){
		if ($php)
			return 'Y/m';
                return 'yyyy/mm';
        }
}
