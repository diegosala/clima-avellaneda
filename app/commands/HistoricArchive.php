<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class HistoricArchive extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'historic_archive';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Archivo de tabla "live" en tabla "historic".';

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
		$deleted = -1;
		DB::beginTransaction();
		DB::statement("INSERT INTO historic (timestamp, temperature, humidity, wind_speed, wind_gust, wind_direction, rain) ".
				"SELECT timestamp, temperature, humidity, wind_speed, wind_gust, wind_direction, rain ".
				"FROM live ".
				"WHERE timestamp < DATE_SUB(NOW(),INTERVAL 1 MONTH)");
		
		$deleted = DB::delete("DELETE FROM live WHERE timestamp < DATE_SUB(NOW(),INTERVAL 1 MONTH)");
		DB::commit();
		
		$this->info("{$deleted} filas eliminadas");

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
