<?php

class Tag extends Model{
	public $table="tags";

	public function posts(){
		//Model
		//pivotTable
		//This model id
		//this pivot table col
		// rel model id
		//rel pivot table col

		return $this->belongsToMany("Post","post_tag");
	}
	
}