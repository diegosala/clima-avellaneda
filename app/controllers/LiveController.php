<?php

class LiveController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function showLive()
        {
                $this->layout->content = View::make('live', array("actuales"=>"Fruta"));
        }	

	public function LastData()
	{	
		$span = 5; // minutes
		return Response::json(DB::table('live')->select('timestamp', 'temperature', 'humidity', 'wind_speed', 'wind_gust', 'wind_direction', 'rain')->orderBy('id', 'desc')->take($span*12)->get());
	}

	public function LiveData() {	
		$this->layout->content = View::make('graficos');		
	}
}
