<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;

class ServicesController extends Controller
{

	public function getIndex(Request $request)
	{
		$services = Service::orderBy('id', 'asc');

		if ($request->phrase) {
			$services->where('id', 'like', '%'.$request->phrase)
				->orWhere('url', 'like', '%'.$request->phrase.'%');
		}

		$services = $services->paginate(25);

		return view('pages.admin.services-list')
			->with('title', 'Services List')
			->with('services', $services);
	}

}
