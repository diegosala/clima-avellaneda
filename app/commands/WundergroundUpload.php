<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class WundergroundUpload extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'weatherunderground:upload';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Uploads data to Weather Underground.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $date = Day::max('date');
		$dayData = Day::where('date', '=', "{$date}")->get()->first();
        $lastData = $dayData->archives->last();

        $lastHourRain = DB::table('archive')->where('day_id', '=', $dayData->id)->orderBy('id', 'desc')->take(6)->lists('rain');        

        $datetime = new DateTime("{$dayData->date} {$lastData->time}");
        $datetime->setTimezone(new DateTimeZone('UTC'));        

        $t=((17.27*$lastData->temperature)/(237.7+$lastData->temperature))+log($lastData->humidity/100);
        $dewPoint = (237.7*$t)/(17.27-$t);        

        $data = array(
            "ID" => "IBUENOSA197",
            "PASSWORD" => "145000",
            "action" => "updateraw",
            "dateutc" => $datetime->format('d/m/Y H:i:s'),
            "tempf" => (9/5) * $lastData->temperature + 32,            
            "winddir" => $lastData->wind_direction == 255 ? 0 : $lastData->wind_direction*22.5,
            "windspeedmph" => 0.621371 * $lastData->wind_speed,
            "windgustmph" => 0.621371 * $lastData->wind_gust,
            "humidity" => $lastData->humidity,
            "dewptf" => (9/5) *$dewPoint + 32,
            "rainin" => 0.0393700787 * array_sum($lastHourRain),
            "dailyrainin" => 0.0393700787 * $dayData->sum_rain,            
        );

        $getData = array();
        foreach ($data as $key=>$value)
            $getData[] = "{$key}={$value}";

        $requestGet = implode("&", $getData);

        $request = Requests::get("http://weatherstation.wunderground.com/weatherstation/updateweatherstation.php?{$requestGet}");

        $this->info("Response from Weather Underground is '{$request->body}'");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
