<?php

class LiveController extends BaseController {
	public function LastData()
	{
		$span = 3; //hours
		return Response::json(DB::table('live')->select('timestamp', 'temperature', 'humidity', 'wind_speed', 'wind_gust', 'wind_direction', 'rain')->orderBy('id', 'desc')->take($span*60*12)->get());
	}
}
