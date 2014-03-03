<?php

use Illuminate\Database\Migrations\Migration;

class WindDirectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wind_directions', function($table) {
			$table->engine = 'InnoDB';			

			$table->smallInteger('id')->unsigned();
			$table->string('code', 3);
			$table->primary('id');
		});

		DB::statement('ALTER TABLE `years` CHANGE COLUMN `wind_direction` `wind_direction` SMALLINT(5) UNSIGNED NULL DEFAULT NULL');
		DB::statement('ALTER TABLE `months` CHANGE COLUMN `wind_direction` `wind_direction` SMALLINT(5) UNSIGNED NULL DEFAULT NULL');
		DB::statement('ALTER TABLE `days` CHANGE COLUMN `wind_direction` `wind_direction` SMALLINT(5) UNSIGNED NULL DEFAULT NULL');
		DB::statement('ALTER TABLE `archive` CHANGE COLUMN `wind_direction` `wind_direction` SMALLINT(5) UNSIGNED NULL DEFAULT NULL');

		Schema::table('years', function($table) {
			$table->foreign('wind_direction')->references('id')->on('wind_directions');
		});

		Schema::table('months', function($table) {
                        $table->foreign('wind_direction')->references('id')->on('wind_directions');
                });

		Schema::table('days', function($table) {
                        $table->foreign('wind_direction')->references('id')->on('wind_directions');
                });

		Schema::table('archive', function($table) {
                        $table->foreign('wind_direction')->references('id')->on('wind_directions');
                });

		Schema::table('live', function($table) {
                        $table->foreign('wind_direction')->references('id')->on('wind_directions');
                });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('years', function($table) {
			$table->dropForeign('years_wind_direction_id');
		});

		Schema::table('months', function($table) {
                        $table->dropForeign('months_wind_direction_id');
                });

		Schema::table('days', function($table) {
                        $table->dropForeign('days_wind_direction_id');
                });

		Schema::table('archive', function($table) {
                        $table->dropForeign('archive_wind_direction_id');
                });

		Schema::table('live', function($table) {
                        $table->dropForeign('live_wind_direction_id');
                });

		Schema::drop('wind_directions');
	}

}
