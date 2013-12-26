<?php

class DailyController extends ArchiveController {
	public function main()
	{
		$view = View::make('archive.daily.main');
		$view->with('day', 0);
		$view->with('daily_section', true);

		$this->layout->content = $this->setUpDatePicker($view);
		$this->layout->with('daily_section', true);
	}

	public function daily($year, $month, $day)
	{
		$dayData = Day::where('date', '=', "{$year}-{$month}-{$day}")->get()->first();
		$this->layout->content = $this->setUpDatePicker(View::make('archive.daily.main')->with('day', $dayData)->with('daily_section', true), "{$year}-{$month}-{$day}");
		$this->layout->with('daily_section', true);
	}

	protected function getDatePickerFormat() {
		return 'yyyy/mm/dd';
	}
}
