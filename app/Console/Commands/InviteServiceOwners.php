<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SupportRole;

class InviteServiceOwners extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'invite-service-owners';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Invite owners';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$support_roles = SupportRole::all();

		foreach ($support_roles as $role) {
			$role->invite();
		}
	}

}
