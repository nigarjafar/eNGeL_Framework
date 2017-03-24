<?php

class Company extends Model{
	public $table="companies";
	protected $softDelete=true;

	
	public function posts(){
		return $this->hasMany("Post");
	}
}