<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapeDataTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scrape_data', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->text('description');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scrape_data');
	}

}
