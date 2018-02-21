<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
	protected $guarded = [];
	
    function getRouteKeyName() {
		return "slug";
	}
    function threads() {
		return $this->hasMany(Thread::class);
	}
}
