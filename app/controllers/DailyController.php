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

	public function daily($year, $month, $day, $raw = false)
	{
		$dayData = Day::where('date', '=', "{$year}-{$month}-{$day}")->get()->first();

		if ($raw)
			return Response::json($dayData->archives);
		
		$view = View::make('archive.daily.main');
		$view->with('day', $dayData);
		$view->with('daily_section', true);
		$view->with('records', $dayData->archives()->paginate(10));

		$this->layout->content = $this->setUpDatePicker($view, "{$year}-{$month}-{$day}");
		$this->layout->with('daily_section', true);
	}

	protected function getDatePickerFormat($php = false) {
		if ($php)
			return 'Y/m/d';
		return 'yyyy/mm/dd';
	}
}
