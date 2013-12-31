<?php

use Illuminate\Database\Migrations\Migration;

class ColumnaArchivado extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("live", function($table) {
			$table->boolean("archived")->default(false);
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
			$table->dropColumn("archived");
		});
	}

}