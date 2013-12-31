<?php

use Illuminate\Database\Migrations\Migration;

class WindDirections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("days", function($table) {
			$table->smallInteger('wind_direction')->after("avg_windspeed")->nullable();
		});
		
		Schema::table("months", function($table) {
			$table->smallInteger('wind_direction')->after("avg_windspeed")->nullable();
		});
		
		Schema::table("years", function($table) {
			$table->smallInteger('wind_direction')->after("avg_windspeed")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("days", function($table) {
			$table->dropColumn("wind_direction");
		});
		
		Schema::table("months", function($table) {
			$table->dropColumn("wind_direction");
		});
		
		Schema::table("years", function($table) {
			$table->dropColumn("wind_direction");
		});
	}

}