<?php

class CommentTable extends Migration{

	public static function up(){
		$comments= self::table("com");
		$comments->id()
				->addColumn("user_id","INT")->notNull()
				->addColumn("name","varchar(255)")->nullable()->defaultValue('Nigar')
				->timeLog()
				->softDelete()
				->save();


	}
	public static function  down(){

	}


}

// Call function
CommentTable::up();