<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTestingSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		DB::table('services')->insert([
			'parent_service_id' => null,
			'interaction_id'    => 'P00013',
			'group_id'          => 'G00010',
			'group_header'      => 0,
			'qgs_service_id'    => 'QGS.00010.01',
			'status'            => 'Active',
			'eligibility'       => 'Demo Service',
			'fees'              => '',
			'url'               => 'http://www.google.com',
			'created_at'        => '2017-04-01 11:43:59',
			'updated_at'        => '2017-04-01 11:44:05',
			'deleted_at'        => null,
		]);

		DB::table('support_roles')->insert([
			'service_id'   => 1,
			'person_name'  => 'Test',
			'service_role' => 'QGS Service owner',
			'phone'        => '',
			'email'        => 'test@buckhamduffy.com',
			'created_at'   => '2017-04-01 22:22:14',
			'updated_at'   => '2017-04-01 22:22:14',
		]);
	}

}
