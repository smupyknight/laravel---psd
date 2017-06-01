<?php

namespace App\Http\Middleware;

use Closure;

class ServiceOwner
{

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!session('email')) {
			return redirect('/email-login')
				->with('errors', 'You are currently not authorised to access the requested URL.');
		}

		return $next($request);
	}

}
