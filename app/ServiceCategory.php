<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{

	protected $table = 'service_categories';

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

}
