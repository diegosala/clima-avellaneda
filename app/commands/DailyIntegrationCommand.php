<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DailyIntegrationCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'daily_integration';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Integrates daily data';

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
	 * @return void
	 */
	public function fire()
	{
		$date = $this->argument('date');
		$this->info("Date is {$date}");

		$count = DB::table('live')->where(DB::raw('date(timestamp)'),$date)->count();
		$this->info("Records for the day: {$count}");

		$records = DB::table('live')
			->select(
					DB::raw('date(timestamp) as date'), 
					DB::raw('max(temperature) max_temperature'), 
					DB::raw('min(temperature) min_temperature'), 
					DB::raw('avg(temperature) avg_temperature'),
					DB::raw('avg(humidity) avg_humidity'),
					DB::raw('max(wind_gust) max_windgust'),
					DB::raw('avg(wind_speed) avg_windspeed'),
					DB::raw('sum(rain)*0.3 sum_rain')
				)
			->where(DB::raw('date(timestamp)'),$date)
			->get();

		$day = Day::where('date',$date)->get();
		if (count($day) == 0)
			$day = new Day;
		else
			$day = $day[0];
		
		$record = $records[0];
		$day->date = $record->date;
		$day->max_temperature = $record->max_temperature;
		$day->max_temperaure_time = DB::table('live')->where(DB::raw('date(timestamp)'), $date)->where('temperature', $record->max_temperature)->pluck('timestamp');
		$day->min_temperature = $record->min_temperature;
		$day->min_temperaure_time = DB::table('live')->where(DB::raw('date(timestamp)'), $date)->where('temperature', $record->min_temperature)->pluck('timestamp');
		$day->avg_temperature = $record->avg_temperature;
		$day->avg_humidity = $record->avg_humidity;
		$day->max_windgust = $record->max_windgust;
		$day->max_windgust_time = DB::table('live')->where(DB::raw('date(timestamp)'), $date)->where('wind_gust', $record->max_windgust)->pluck('timestamp');
		$day->avg_windspeed = $record->avg_windspeed;
		$day->sum_rain = $record->sum_rain;

		$day->save();	
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('date', InputArgument::OPTIONAL, 'Date to integrate.', date("Y-m-d")),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
