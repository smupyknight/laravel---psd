<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvitationsController extends Controller
{

	public function getAccept(Request $request, $email)
	{
		$request->session()->put('email', $email);

		return redirect('/services');
	}

}
