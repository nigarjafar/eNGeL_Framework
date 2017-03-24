<?php

class Post extends Model{
	public $table="posts";
	protected $softDelete=true;

	public function company(){
		return $this->belongsTo("Company");
	}
	
}