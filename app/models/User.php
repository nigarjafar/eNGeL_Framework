<?php

class User extends Model{
	public $table="users";
	protected $softDelete=true;

	public function company(){
		return $this->hasOne("Company");
	}
	
}