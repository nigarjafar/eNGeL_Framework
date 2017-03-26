<?php

class Tag extends Model{
	public $table="tags";

	public function posts(){
		
		return $this->belongsToMany("Post","post_tag");
	}
	
}