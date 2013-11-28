<?php

class LiveController extends BaseController {
	protected $layout = 'layouts.master';

	public function showLive()
	{
		$this->layout->content = View::make('live', array("actuales"=>"Fruta"));
	}
}
