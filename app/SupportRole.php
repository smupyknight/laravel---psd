<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mail;

class SupportRole extends Model
{

	public function services()
	{
		return $this->belongsTo('App\Service');
	}

	public function invite()
	{
		if (!$this->email) {
			return;
		}

		Mail::to($this->email)
			->queue(new \App\Mail\InviteOwner($this));
	}

}
