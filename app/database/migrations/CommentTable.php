<?php

class CommentTable extends Migration{

	public static function up(){
		$comments= self::table("commmm");
		$comments->id()
				->addColumn("surname","varchar(255)")
				->addColumn("user_id","INT UNSIGNED")->foreignKey("users","id")
				->addColumn("post_id","INT UNSIGNED")->foreignKey("posts","id")
				->timelog()
				->softDelete()
				->save();


	}
	public static function  down(){

	}


}

// Call function
CommentTable::up();