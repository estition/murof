<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Filters;
use Illuminate\Http\Request;
/**
 * Description of Filters
 *
 * @author rafael
 */
class Filters {

	
	protected $request,$builder;
	protected $filters = [];

	public function __construct(Request $request) {
		$this->request = $request;
	}
	public function apply($builder){
		$this->builder = $builder;
		
		
//	Equivalent to foreach:
//			collect($this->getFilters())->filter(function($value, $filter){
//			return method_exists($this, $filter);
//		})->each(function($value, $filter){
//		$this->$filter($value);
//		});
//	
//			
//		$this->getFilters1()->filter(function($filter){
//			return method_exists($this, $filter);
//		})->each(function($value, $filter){
//		$this->$filter($value);
//		});
		
		
		foreach ($this->getFilters() as $filter => $value){
			if(method_exists($this, $filter)) {
			
			$this->$filter($value);
			}
		}
		return $this->builder;
	
	}
//	public function getFilters1() {
//		return collect($this->request->intersect($this->filters))->flip();
//	}
	public function getFilters() {
//		return $this->request->intersect($this->filters);
		return array_filter($this->request->only($this->filters));
	}
//	protected function hasFilters($filter) {
//		return method_exists($this, $filter) && $this->request->has($filter);
//	}
}
