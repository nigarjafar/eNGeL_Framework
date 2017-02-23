<?php

class User extends Model{
	public $username;


	public function getUserById($id){
		return $this->db->SelectById($this->table,$id);
	}
}