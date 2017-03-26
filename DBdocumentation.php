<?php

//__________________________________________________________________________//

//****************************** Migrations ********************************//
//__________________________________________________________________________//


// in app/database/migrations write the following code structure
<?php

class TableNameTable extends Migration{ 

	public static function up(){
		$comments= self::table("table_name"); // create table object. Table name will be comments.
		$comments->id()	// Add id column. Properties: unsigned int, not null , autoincrement and primary key.
				->addColumn("name","varchar(255)")
				->timeLog()
				->softDelete()
				->save();
	}
	public static function  down(){}

}

// Call function
CommentTable::up();



//*****methods:*****//
 addColumn(column_name,type)->nullable() // - allow null values
 addColumn(column_name,type)->notNull() // - doesn't allow null values
 addColumn(column_name,type)->primaryKey() // -	add  primary key constraint
 addColumn(column_name,type)->unique()  //-	add unique constraint
 addColumn(column_name,type)->autoIncrement() // -	add auto_increment field
 addColumn(column_name,type)->defaultValue("default") // -	provide a default value for a column.



id() // Add id column. Properties: unsigned int, not null , autoincrement and primary key.
timeLog() -> add created_at and updated_at columns.
softDelete() -> add deleted_at column

//****Foreign key****//
addColumn("user_id","INT UNSIGNED")->foreignKey("users","id")
addColumn(column_name,type)->foreignKey(reference_table,reference_column)// Be careful about type of foreign key: if reference column and foreign key column type are not the same, it will cause an error. Type of ids that created by id() method is INT UNSIGNED.



//**** In app folder, add require_once('database/migrations/TableNameTable.php') to migrate.php ****//
//**** In app folder, open cmd and write php migrate.php ****//



//__________________________________________________________________________//

//****************************** Models ************************************//
//__________________________________________________________________________//


$user=$this->model('User'); // Create User model object.
$user->setTable('users');   // Set table which you want to use.
//***get&***//
$user->get() //return the results  (all columns)
$user->get('colname') //return the only selected column (only 1 column) 
$user->get( 'colname1','colname2',.. ) //return the only selected columnS (many columns)

//***first***//
$user->first( ) //return the only first resulr
$user->first('colname') //
$user->first( ['colname1','colname2'] ) //

$user->rawQuery('query') // send query 

$user->create([					//create new row
		'colname'=>'value',
		'colname1'=>'value1'
		]);


$user->update([					//update selected row(s)

		'colname'=>'value',
		'colname1'=>'value1'
		])

$user->delete( ) //delete selected row(s)
		
//****Where****//
$user->where('id',1)->get() // where id=1 
$user->where('id','<',2)	//where id<2
$user->where([							//where col1<value AND col2=value AND col3 LIKE value 
				['col1','<','value'],
				['col2','=','value'],
				['col3','LIKE','value']

			])->get()

$user->whereBetween($col,$from,$to)->get() //WHERE col BETWEEN $from AND $to;
$user->whereNotBetween($col,$from,$to)->get() //WHERE col NOT BETWEEN $from AND $to;
$user->whereIn($col,[$in1,$in2,...])->get()  //$in is array-> WHERE $col IN ($in1,$in2...)
$user->whereNotIn($col,[$in1,$in2,...])->get()  //$in is array-> WHERE $col NOT IN ($in1,$in2...)
$user->whereNull($col)->get()  //WHERE $col is NULL
$user->whereNotNull($col)->get()  //WHERE $col is NOT NULL
$user->whereColumn($col1, $col2) //WHERE $col1=$col2
$user->whereColumn($col1,$operand, $col2) //WHERE $col1 $operand $col2 //$operand: = < > LIKE ...
$user->whereColumn([				//WHERE `created_at`> `updated_at` AND  `name` LIKE `surname  / 
				['created_at','>','updated_at'],
				['name','LIKE','surname'],
			])->get()
//****orWhere****//
$user->where('id',1)->orWhere('name', 'John')->get() // id=1 OR name=John
$user->where('id',2)->orWhere('id','>',5)->get()	//where id=2 OR id>5
$user->where('id',1)->orWhere([				//where id=1 OR col1<value1 OR col2 = value2 OR col3 LIKE value3  
				['col1','<','value1'],
				['col2','=','value2'],
				['col3','LIKE','value3']

			])->get()
//*******//
$user->orderBy('id','asc')->get()//  .... ORDER BY id ASC
$user->inRandomOrder()->get()
$user->limit( 5)->get() //.... LIMIT 5
$user->offset( 5)->get() //.... OFFSET 5
//******//
$user->count()->get() //SELECT COUNT
$user->max('id')->get() //SELECT MAX(id)
$user->min('id')->get() //SELECT  MIN(id)
$user->avg('id')->get() //SELECT AVG(id)
$user->sum('id')->get() // SELECT SUM(id)
//******//
$user->distinct() // SELECT DISTINCT ...

//**Joins***// 
//Inner
join($joinTable,$baseTableCol,$operator,$joinTableCol)
$user->join('companies','users.id','=','companies.user_id')
	->get('users.*','companies.id') // SELECT * FROM users JOIN companies ON users.id = companies.user_id 
//Left
leftJoin($joinTable,$baseTableCol,$operator,$joinTableCol)
$user->leftJoin('companies','users.id','=','companies.user_id')
	->get('users.*','companies.id') // SELECT * FROM users LEFT JOIN companies ON users.id = companies.user_id 
//Right
rightJoin($joinTable,$baseTableCol,$operator,$joinTableCol)
$user->rightJoin('companies','users.id','=','companies.user_id')
	->get('users.*','companies.id') // SELECT * FROM users RIGHT JOIN companies ON users.id = companies.user_id
//Cross
crossJoin($joinTablel)
$user->crossJoin('companies')
	->get('users.*','companies.id') // SELECT * FROM users CROSS JOIN companies







//__________________________________________________________________________//

//****************************** Soft Delete ********************************//
//__________________________________________________________________________//

$user->delete() //When soft deleting a model, it is not actually removed from your database. Instead, a deleted_at timestamp is 				set on the record. When querying a model that uses soft deletes, the "deleted" models will not be included in 					query results.
$user->forceDelete() // delete row from database
$user->recover() //recover soft deleted row
$user->withTrash() //return results with "deleted" models.




//__________________________________________________________________________//

//****************************** Model-> Relationships **********************//
//__________________________________________________________________________//



//________________________________________________//

//One To One//
//_______________________________________________//
belongsTo($model,$baseTableCol,$relTableCol) 
belongsTo($model)

/*****Post table*******/
//
// |id|company_id|title|body|....Here company_id is $baseTableCol
//
// ****Company table******
//
// |id|name|info|phone|....Here id is $relTableCol
//


class Post extends Model{
	public $table="posts";

	public function company(){
		return $this->belongsTo("Company"); 
		//This is equal to 
		//return $this->belongsTo("Company","company_id","id"); 
	}
	
}

//________________________________________________________________________//

hasOne($model,$baseTableCol,$relTableCol)
hasOne($model) 

/*****User table*******/
//
// |id|name|type|....Here id is $baseTableCol
//
// ****Company table******
//
// |id|user_id|info|phone|....Here user_id is $relTableCol


class User extends Model{
	public $table="users";

	public function company(){
		return $this->hasOne("Company");
		//This is equal to
		//return $this->hasMany("Company","id","user_id");
	}
}
//________________________________________________//

//One To Many//
//_______________________________________________//


hasMany($model,$baseTableCol,$relTableCol)
hasMany($model) 

/*****Post table*******/
//
// |id|company_id|title|body|....Here company_id is $relTableCol
//
// ****Company table******
//
// |id|name|info|phone|....Here id is $baseTableCol
//

class Company extends Model{
	public $table="companies";
		
	public function posts(){
		return $this->hasMany("Post");
		//This is equal to
		//return $this->hasMany("Post","id","company_id");
	}
}


//Reverse in One To Many is belongsTo as One to One.


//________________________________________________//

//One To Many//
//_______________________________________________//

belongsToMany($model,$pivotTable,$baseCol,$basePivotCol,$relCol,$relPivotCol)
belongsToMany($model,$pivotTable)

/*****Post table*******/
//
// |id|company_id|title|body|....Here  id is $relCol
//
// ****Tag table******
//
// |id|name|.. Here  id is $baseCol
//
// ******post_tag******// 
// |post_id|tag_id| // tag_id is $basePivotCol , post_id is $relPivotCol

class Tag extends Model{
	public $table="tags";

	public function posts(){
		return $this->belongsToMany("Post","post_tag");
		//This is equal to
		//return $this->belongsToMany("Post","post_tag","id","tag_id","id","post_id");

	}
	
}

//In order to use less parameters in functions column in db names should be as follow
// id (every table must have "id")
// user_id,company_id ... (Not userId or smt else)  (in dependent tables)


