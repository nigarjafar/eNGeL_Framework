<?php

class User extends Model{
	public $username;


	public function getById($id){
		return $this->db->SelectById($this->table,$id);
	}
}