<?php
function create($class, $attributes = [], $time = null){
	return factory($class, $time)->create($attributes);
}
function make($class, $attributes = [], $time = null){
	return factory($class, $time)->make($attributes);
}