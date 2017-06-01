<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialSchemaSetup extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		Schema::create('services', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('parent_service_id')->unsigned()->nullable();
			$table->string('interaction_id');
			$table->string('group_id');
			$table->boolean('group_header');
			$table->string('qgs_service_id');
			$table->enum('status', ['Pending', 'Active', 'To Be Removed']);
			$table->text('eligibility');
			$table->text('fees');
			$table->text('url');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		    $table->softDeletes();

			$table->foreign('parent_service_id')->references('id')->on('services');
		});

		Schema::create('prerequisites', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->text('content');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		    $table->softDeletes();

			$table->foreign('service_id')->references('id')->on('services');
		});

		Schema::enableForeignKeyConstraints();

		Schema::create('keywords', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('service_id')->unsigned();
			$table->string('word');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		    $table->softDeletes();

			$table->foreign('service_id')->references('id')->on('services');
		});

		Schema::create('names', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->string('name', 250);
			$table->string('context');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		    $table->softDeletes();

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('descriptions', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->text('description');
			$table->string('context');
			$table->datetime('created_at');
			$table->datetime('updated_at');
			$table->softDeletes();

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('events', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->string('name');
			$table->integer('sequence')->unsigned();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name', 50);
			$table->string('type', 50);
			$table->datetime('created_at');
			$table->datetime('updated_at');
			$table->softDeletes();
		});

		Schema::create('service_categories', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->datetime('created_at');
			$table->datetime('updated_at');
			$table->softDeletes();

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
		});

		Schema::create('forms', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->string('name', 250);
			$table->text('url');
			$table->string('source', 50);
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('evidence', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->string('name');
			$table->string('displayed_for');
			$table->text('meta_data');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('related_services', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->integer('related_service_id')->unsigned();
			$table->string('relationship');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->unique(['service_id', 'related_service_id']);

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
			$table->foreign('related_service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('virtual_delivery_channels', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->text('details');
			$table->text('additional_details');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('locations', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('name', 100);
			$table->string('type', 50);
			$table->string('agency', 50);
			$table->text('accessibility_facilities', 250);
			$table->string('additional_information');
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('delivery_channels', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->integer('virtual_delivery_channel_id')->unsigned()->nullable();
			$table->integer('location_id')->unsigned()->nullable();
			$table->string('name');
			$table->enum('status', ['Closed', 'Open'])->nullable();
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
			$table->foreign('virtual_delivery_channel_id')->references('id')->on('virtual_delivery_channels')->onDelete('cascade');
			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
		});

		Schema::create('support_roles', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->string('person_name', 100);
			$table->string('service_role', 100);
			$table->string('phone', 10);
			$table->string('email');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('agencies', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('code');
			$table->text('name');
			$table->string('type', 50);
			$table->string('url', 250);
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('agency_support_roles', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('code', 50);
			$table->string('name', 50);
			$table->string('email');
			$table->string('context', 500);
			$table->datetime('created_at');
			$table->datetime('updated_at');
		});

		Schema::create('delivery_organisations', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('service_id')->unsigned();
			$table->text('business_unit_name');
			$table->string('code');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('virtual_delivery_hours', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('virtual_delivery_channel_id')->unsigned()->nullable();
			$table->string('monday', 50);
			$table->string('tuesday', 50);
			$table->string('wednesday', 50);
			$table->string('thursday', 50);
			$table->string('friday', 50);
			$table->string('saturday', 50);
			$table->string('sunday', 50);
			$table->text('comments');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('virtual_delivery_channel_id')->references('id')->on('virtual_delivery_channels')->onDelete('cascade');
		});

		Schema::create('location_addresses', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('address_type', 20);
			$table->string('address_one');
			$table->string('address_two');
			$table->string('suburb', 50);
			$table->string('postcode', 4);
			$table->string('latitude');
			$table->string('longitude');
			$table->text('additional_information');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
		});

		Schema::create('location_phone_numbers', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('phone_number', 20);
			$table->text('comments');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
		});

		Schema::create('location_emails', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('email', 100);
			$table->text('comments');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('location_id')->references('id')->on('services')->onDelete('cascade');
		});

		Schema::create('location_hours', function(Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('monday', 50);
			$table->string('tuesday', 50);
			$table->string('wednesday', 50);
			$table->string('thursday', 50);
			$table->string('friday', 50);
			$table->string('saturday', 50);
			$table->string('sunday', 50);
			$table->text('comments');
			$table->string('valid_to');
			$table->string('valid_from');
			$table->datetime('created_at');
			$table->datetime('updated_at');

			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::disableForeignKeyConstraints();
		Schema::drop('services');
		Schema::drop('prerequisites');
		Schema::drop('agencies');
		Schema::drop('agency_support_roles');
		Schema::drop('categories');
		Schema::drop('delivery_channels');
		Schema::drop('delivery_organisations');
		Schema::drop('descriptions');
		Schema::drop('events');
		Schema::drop('evidence');
		Schema::drop('forms');
		Schema::drop('keywords');
		Schema::drop('location_addresses');
		Schema::drop('location_emails');
		Schema::drop('location_hours');
		Schema::drop('location_phone_numbers');
		Schema::drop('locations');
		Schema::drop('names');
		Schema::drop('related_services');
		Schema::drop('service_categories');
		Schema::drop('support_roles');
		Schema::drop('virtual_delivery_channels');
		Schema::drop('virtual_delivery_hours');
		Schema::enableForeignKeyConstraints();
	}

}
