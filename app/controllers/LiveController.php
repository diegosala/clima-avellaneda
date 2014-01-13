<?php

class LiveController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function showLive()
    	{
		$rawForecast = Cache::get("forecast");
		$forecast = new Forecast($rawForecast);            
		
		$this->layout->content = View::make('live')->with("forecast", $forecast->getDailyForecast());
    }

	public function LastData($span)
	{	        		
		return Response::json(DB::table('live')->select(DB::raw('unix_timestamp(timestamp) timestamp'), 'temperature', 'humidity', 'wind_speed', 'wind_gust', 'wind_direction', 'rain')->orderBy('id', 'desc')->take($span*12)->get());
	}

	public function LiveData($span = 5, $unit = 'minutes') {	
		$this->layout->content = View::make('graficos')->with('span', $span);		
	}
}
