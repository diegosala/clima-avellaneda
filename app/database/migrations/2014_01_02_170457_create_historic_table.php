<?php

use Illuminate\Database\Migrations\Migration;

class CreateHistoricTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historic', function($table) {
                        $table->dateTime('timestamp');
                        $table->decimal('temperature',4,2);
                        $table->integer('humidity')->unsigned();
                        $table->integer('wind_speed')->unsigned();
                        $table->integer('wind_gust')->unsigned();
                        $table->smallInteger('wind_direction')->unsigned();
                        $table->smallInteger('rain')->unsigned();
			
			$table->engine = 'MyISAM';
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historic');
	}

}
