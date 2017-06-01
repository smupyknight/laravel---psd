<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

	public function getEmailLogin()
	{
		return view('pages.email-login');
	}

	public function postEmailLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
		]);

		$request->session()->put('email', $request->email);

		return redirect('/services');
	}

	public function getEmailLogout(Request $request)
	{
		$request->session()->flush();

		return redirect('/email-login');
	}

}
