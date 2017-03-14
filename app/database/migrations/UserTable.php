<?php

class UserTable extends Migration(){

	public function up(){
		$comments= $this->table("comments");
		$comments->addColumn("user_id","INT")->save();

		
	}
	public function down(){}


}