<?php

class DailyController extends BaseController {
	protected $layout = 'layouts.master';

	public function main()
	{
		$this->layout->content = View::make('daily');
	}
}
