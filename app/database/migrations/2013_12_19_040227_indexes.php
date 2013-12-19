<?php

use Illuminate\Database\Migrations\Migration;

class Indexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("live", function($table) {
			$table->dateTime("date_period")->after("timestamp");
			$table->index('date_period');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("live", function($table) {
			$table->dropColumn("date_period");
		});
	}

}