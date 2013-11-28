<?php

use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('years', function($table) {
			$table->bigIncrements('id')->unsigned();
			$table->decimal('max_temperature',5,2);
			$table->dateTime('max_temperaure_date');
			$table->decimal('min_temperature',5,2);
                        $table->dateTime('min_temperaure_date');
			$table->decimal('avg_temperature',5,2);
			$table->decimal('avg_humidity',3,1)->unsigned();
			$table->integer('max_windgust')->unsigned();
			$table->dateTime('max_windgust_date');
			$table->decimal('avg_windspeed',3,1);
			$table->decimal('sum_rain',6,1);
		});

		Schema::create('months', function($table) {
                        $table->bigIncrements('id')->unsigned();
			$table->bigInteger('year_id')->unsigned();
			$table->smallInteger('month')->unsigned();
                        $table->decimal('max_temperature',5,2);
                        $table->dateTime('max_temperaure_date');
                        $table->decimal('min_temperature',5,2);
                        $table->dateTime('min_temperaure_date');
                        $table->decimal('avg_temperature',5,2);
                        $table->decimal('avg_humidity',3,1)->unsigned();
                        $table->integer('max_windgust')->unsigned();
                        $table->dateTime('max_windgust_date');
                        $table->decimal('avg_windspeed',3,1);
                        $table->decimal('sum_rain',6,1);

			$table->foreign('year_id')->references('id')->on('years');
                });
		
		Schema::create('days', function($table) {
                        $table->bigIncrements('id')->unsigned();
                        $table->bigInteger('month_id')->unsigned();
                        $table->date('date');
                        $table->decimal('max_temperature',5,2);
                        $table->time('max_temperaure_time',5,2);
                        $table->decimal('min_temperature',5,2);
                        $table->time('min_temperaure_time');
                        $table->decimal('avg_temperature',5,2);
                        $table->decimal('avg_humidity',3,1)->unsigned();
                        $table->integer('max_windgust')->unsigned();
                        $table->time('max_windgust_time');
                        $table->decimal('avg_windspeed',3,1);
                        $table->decimal('sum_rain',6,1);

                        $table->foreign('month_id')->references('id')->on('months');
                });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('years');
		Schema::drop('months');
		Schema::drop('days');
	}

}
