<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Service;
use GuzzleHttp\Client;
use App\ScrapeData;
use Log;
use App\Description;
use App\Keyword;

class ScrapeService implements ShouldQueue
{

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private $service;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(Service $service)
	{
		$this->service = $service;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$service = $this->service;

		if ($service->descriptions()->whereContext('Auto')->exists()) {
			$existing_description = $service->descriptions()->whereContext('Auto')->first();
			$existing_description->context = 'Auto-Archived';
			$existing_description->save();
		}

		Log::info('Scraping URL: ' . $service->url);

		$client = new \GuzzleHttp\Client();

		$res = $client->request('GET', 'https://api.diffbot.com/v3/article', [
			'query' => ['token' => '4d5c972e80b52fccde5ecef0a105cee9', 'url' => $service->url]
		]);

		$data = json_decode($res->getBody()->getContents());

		$description = new Description;

		$description->service_id = $service->id;
		$description->description = isset($data->objects[0]->html) ? $data->objects[0]->html : '';
		$description->context = 'Auto';

		$description->save();

		if (isset($data->objects[0]->tags)) {
			foreach ($data->objects[0]->tags as $tag) {
				$keyword = new Keyword;

				$keyword->service_id = $service->id;
				$keyword->word = $tag->label;
				$keyword->score = $tag->score;

				$keyword->save();
			}
		}
	}

}
