<?php

class YearlyController extends BaseController {
	protected $layout = 'layouts.master';

	public function main()
	{
		$this->layout->content = View::make('yearly');
	}
}
