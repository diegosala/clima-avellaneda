<?php

class ForecastController extends BaseController {
        protected $layout = 'layouts.archive';

        public function main() 
	{
		$f = Cache::get("forecast");
		$this->layout->content = View::make('forecast')->with('forecast', $f);
        }
}
