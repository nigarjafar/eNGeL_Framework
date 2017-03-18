<?php 


abstract class Migration{

	//create a new Table object and return it
	public function table($table){
		return new Table($table);
	}


	abstract protected static function up();
	abstract protected static function down();


}