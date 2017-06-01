<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

	public function addresses()
	{
		return $this->hasMany('App\LocationAddress');
	}

	public function emails()
	{
		return $this->hasMany('App\LocationEmail');
	}

	public function hours()
	{
		return $this->hasMany('App\LocationHour');
	}

	public function phoneNumbers()
	{
		return $this->hasMany('App\LocationPhoneNumber');
	}

}
