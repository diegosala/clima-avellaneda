<?php

class YearlyController extends ArchiveController{
	public function main()
	{
                $view = View::make('archive.yearly.main');
                $view->with('year', 0);
                $view->with('yearly_section', true);                	

                $this->layout->content = $this->setUpdatePicker($view);
                $this->layout->with('yearly_section', true);
	}

	public function yearly($year)
	{	
		$yearData = Year::find($year);
		$this->layout->content = $this->setUpdatePicker(View::make('archive.yearly.main')->with('year', $yearData)->with('yearly_section', true), "{$year}");
		$this->layout->with('yearly_section', true);
	}

	protected function getDatePickerFormat($php = false) {
		if ($php)
			return "Y";
                return 'yyyy';
       }
}
