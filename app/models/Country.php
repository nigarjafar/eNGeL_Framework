<?php

class Country extends Model{
	public $table="countries";

	public function posts(){
		return $this->hasManyThrough("Company","Post");
	}
	
}