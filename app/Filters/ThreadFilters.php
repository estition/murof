<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Filters;

use App\User;

/**
 * Description of ThreadFilters
 *
 * @author rafael
 */
class ThreadFilters extends Filters {
	
	protected $filters = ['by', 'popular', 'unanswered'];


	public function by($username) {
		$user = User::where('name', $username)->firstOrFail();
		return $this->builder->where('user_id', $user->id);
	}
	public function popular() {
		$this->builder->getQuery()->orders = [];
		return $this->builder->orderBy('replies_count', 'desc');
	}
	/**
     * Filter the query according to those that are unanswered.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
