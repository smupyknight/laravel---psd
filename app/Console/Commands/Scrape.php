<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ScrapeData;
use App\Service;
use GuzzleHttp\Client;
use App\Jobs\ScrapeService;

class Scrape extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scrape-descriptions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Scrapes the descriptions from the services';

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
		$services = Service::where('url', '!=', '')->get();

		foreach ($services as $service) {
			if ($service->url == '') {
				continue;
			}

			dispatch(new ScrapeService($service));
		}
	}
}