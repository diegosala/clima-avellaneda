<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LiveOptimization extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `live` CHANGE COLUMN `rain` `rain` TINYINT(1) UNSIGNED NOT NULL');
		Schema::table('live', function($table)
		{
			$table->index('archived');
			$table->integer('uptime')->unsigned()->after('battery')->default(0);		
			$table->tinyInteger('retry')->after('uptime')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `live` CHANGE COLUMN `rain` `rain` SMALLINT(5) UNSIGNED');
		Schema::table('live', function($table)
                {
                        $table->dropIndex('live_archived_index');
			$table->dropColumn('uptime');
			$table->dropColumn('retry');
                });

	}

}
