<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use \Illuminate\Support\Facades\Redis;
/**
 * Description of Visits
 *
 * @author rafael
 */
class Visits {
	protected $thread;
	public function __construct($thread) {
		$this->thread = $thread;
		
	}
	
	public function reset() {
		Redis::del($this->cacheKey());
		return $this;
		
	}
	public function count() {
		return Redis::get($this->cacheKey()) ?? 0;
		
	}
	public function record() {
		Redis::incr($this->cacheKey());
		return $this;
		
	}
	public function cacheKey() {
		return "threads.{$this->thread->id}.visits";
	}
}
