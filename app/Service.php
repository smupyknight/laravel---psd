<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

	public function descriptions()
	{
		return $this->hasMany('App\Description');
	}

	public function names()
	{
		return $this->hasMany('App\Name');
	}

	public function getServiceName()
	{
		return $this->names()->whereContext('QGS service name')->first() ? $this->names()->whereContext('QGS service name')->first()->name : '';
	}

	public function serviceCategories()
	{
		return $this->hasMany('App\ServiceCategory');
	}

	public function deliveryOrganisationAgency()
	{
		return $this->hasOne('App\DeliveryOrganisation');
	}

	public function supportRole()
	{
		return $this->hasOne('App\SupportRole');
	}

	public function getServiceOwner()
	{
		return $this->supportRole()->whereServiceRole('QGS Service Owner')->first();
	}

	public function parentService()
	{
		return $this->hasOne('App\Service', 'parent_service_id');
	}

	public function keywords()
	{
		return $this->hasMany('App\Keyword');
	}

	public function events()
	{
		return $this->hasMany('App\Event');
	}

	public function evidence()
	{
		return $this->hasMany('App\Evidence');
	}

	public function prerequisites()
	{
		return $this->hasMany('App\Prerequisite');
	}

}
