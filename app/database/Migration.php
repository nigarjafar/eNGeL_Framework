<?php 

class Migration{

	public function table($table){
		return new Table($table);
	}


	abstract protected function up();
	abstract protected function down();


}