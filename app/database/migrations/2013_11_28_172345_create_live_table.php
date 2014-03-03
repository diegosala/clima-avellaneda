<?php

use Illuminate\Database\Migrations\Migration;

class CreateLiveTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('live', function($table) {
			$table->engine = 'InnoDB';

			$table->bigIncrements('id')->unsigned();
			$table->dateTime('timestamp');
			$table->decimal('temperature',4,2);
			$table->integer('humidity')->unsigned();
			$table->integer('wind_speed')->unsigned();
			$table->integer('wind_gust')->unsigned();
			$table->smallInteger('wind_direction')->unsigned();
			$table->smallInteger('rain')->unsigned();
			$table->decimal('battery',5,3)->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('live');
	}

}
