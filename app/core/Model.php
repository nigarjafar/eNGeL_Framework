<?php

class Model{
	private $db;
	public $table;
	protected $where;
	protected $withTrash=false;
	protected $attributes; 
	public function __construct(){
		$con=new DBConnection();
		$this->db=new DB($con);
	}

	//function for raw query
	public function rawQuery($query){
        $dbResults=$this->db->raw($query)->Query()->Get();

        $objects=array();

        //Creating models foreach db result
		foreach($dbResults as $dbKey => $result){
			//Create new model
			$model=new $this();
			//Set dynamic parameters
			foreach ($result as $key => $value) {
				$model->$key=$value;
			}
			array_push($objects,$model);
		}

		return $objects;

    }


    //set table name
	public function setTable($table){
		$this->table=$table;
	}

	//Create new row
	public function create($data){
		$this->db->insert($this->table, $data)->Query();
		return true;
	}

	//Update row

	public function update($data){

		//Check for soft delete is set or not. If soft delete is used, result will be only NoN delete rows.
		//if withTrashed function is called , so withTrashed will be true, !withTrashed will be false
		// And whereNull('deleted_at') won't run.

		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash)
			$this->whereNull($this->table.'.deleted_at');
		

		$this->withTrash=false;

		return $this->db->Update($this->table,$data)->Query()->rowCount();

	}

	//if softDelete is true, update deleted_at by current time
	//else delete row
	public function delete(){
		
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}

		if(isset($this->softDelete) && $this->softDelete)
			return $this->db->SoftDelete($this->table)->Query()->RowCount();
		else
			return $this->db->Delete($this->table)->Query()->RowCount();

	}
	//Delete row without checking softdelete
	public function forceDelete(){
		return $this->db->	Delete($this->table)->Query()->RowCount();
	}

	//Recover soft deleted rows
	public function recover(){
		$this->withTrash()->update(["deleted_at"=>null]);
		return $this;
	}

	//Return row from DB
	public function get(){

		//Check for soft delete is set or not. If soft delete is used, result will be only NoN delete rows.
		//if withTrashed function is called , so withTrashed will be true, !withTrashed will be false
		// And whereNull('deleted_at') won't run.
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		//Get result from database .  If there is any argument,then we send them by func_get_args method
		if(func_num_args()>0)
			$dbResults= $this->db->Select($this->table,func_get_args())->Query()->Get();
		else 
			$dbResults= $this->db->Select($this->table)->Query()->Get();
		//This will be returned as result
		$objects=array();
		
		//Creating models foreach db result
		foreach($dbResults as $dbKey => $result){
			//Create new model
			$model=new $this();
			//Set dynamic parameters
			foreach ($result as $key => $value) {
				$model->$key=$value;
			}
			array_push($objects,$model);
		}
		
		return $objects;

	}

	//Set where statement. 
	public function where(){
		// where ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'AND');
			}
		}

		// where( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=(func_get_args()[1])?func_get_args()[1]:"is null";
			$this->db->SetWhereStatement($datum,'AND');

		}

		//where(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=(func_get_args()[1])?func_get_args()[1]:"is null";

			$this->db->SetWhereStatement($datum,'AND');

		}
		return $this;
	}

	
	public function orWhere(){
		// orWhere ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'OR');
			}
		}

		// orWhere( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->db->SetWhereStatement($datum,'OR');

		}

		//orhere(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];

		}

		return $this;
	}

	public function withTrash(){
		$this->withTrash=true;
		return $this;
	}

	//whereBetween
	public function whereBetween($col, $from,$to){
		echo "hello between model <hr>";
		$datum[0]=$col;
		$datum[1]=$from;
		$datum[2]=$to;
		$this->db->SetWhereStatement($datum,'AND','between');

		return $this;
	}

	public function whereNotBetween($col, $from,$to){
		echo "hello notbetween model <hr>";
		$datum[0]=$col;
		$datum[1]=$from;
		$datum[2]=$to;
		$this->db->SetWhereStatement($datum,'AND','notBetween');

		return $this;
	}
	public function whereIn($col, $in){
		$datum[0]=$col;
		$datum[1]=$in;
		$this->db->SetWhereStatement($datum,'AND','in');

		return $this;
	}

	public function whereNotIn($col, $in){
		$datum[0]=$col;
		$datum[1]=$in;
		$this->db->SetWhereStatement($datum,'AND','notIn');

		return $this;
	}
	

	public function whereNull($col){
		$datum[0]=$col;
		$this->db->SetWhereStatement($datum,'AND','null');

		return $this;
	}

	public function whereNotNull($col){
		$datum[0]=$col;
		$this->db->SetWhereStatement($datum,'AND','notNull');

		return $this;
	}

	public function whereColumn(){
// whereColumn ([ [key,operator,value],[key,operator,value],.... ])
		if(func_num_args()==1){
			foreach (func_get_args()[0] as $datum) {
				$this->db->SetWhereStatement($datum,'AND','column');
			}
		}

		// whereColumn( key,value) // default is =
		else if(func_num_args()==2){
			$datum[0]=func_get_args()[0];
			$datum[1]="=";
			$datum[2]=func_get_args()[1];
			$this->db->SetWhereStatement($datum,'AND','column');

		}

		//whereColumn(key,operator,value) 
		else if(func_num_args()==3){
			$datum[0]=func_get_args()[0];
			$datum[1]=func_get_args()[1];
			$datum[2]=func_get_args()[2];
			$this->db->SetWhereStatement($datum,'AND','column');

		}

		return $this;
	}

	public function orderBy($col,$rule){
		$this->db->SetOrderStatement($col,$rule);
		return $this;
	}

	public function inRandomOrder(){
		$this->db->SetOrderStatement(null,"RAND()");
		return $this;
	}

	public function limit($number){
		$this->db->SetLimitStatement($number);
		return $this;
	}

	public function first(){
		//If no argument (cols) is specified
		if (!func_num_args())
			return $this->limit(1)->get()[0];
		//if there are arguments
		//Implode them bt comma and call get function
		else
			return $this->limit(1)->get(implode(',',func_get_args()))[0];
	}

	public function offset($number){
		$this->db->SetOffsetStatement($number);
		return $this;
	}

	public function count(){
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		return $this->db->Select($this->table,"COUNT(*)")->Query()->Get();
	}

	public function max($col){
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		return $this->db->Select($this->table,"MAX(`".$col."`)")->Query()->Get();
	}
	public function min($col){
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		return $this->db->Select($this->table,"MIN(`".$col."`)")->Query()->Get();
	}

	public function avg($col){
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		return $this->db->Select($this->table,"AVG(`".$col."`)")->Query()->Get();
	}

	public function sum($col){
		if(isset($this->softDelete) && $this->softDelete && !$this->withTrash){
			$this->whereNull($this->table.'.deleted_at');
			$this->withTrash=false;
		}
		return $this->db->Select($this->table,"SUM(`".$col."`)")->Query()->Get();
	}

	public function distinct(){
		$this->db->SetDistinctStatement();
		return $this;
				
	}

	public function join($joinTable,$baseTableCol,$operator,$joinTableCol){
		$this->db->SetJoinStatement("INNER",$joinTable,$baseTableCol,$operator,$joinTableCol);
		return $this;	
	}

	public function leftJoin($joinTable,$baseTableCol,$operator,$joinTableCol){
		$this->db->SetJoinStatement("LEFT",$joinTable,$baseTableCol,$operator,$joinTableCol);
		return $this;	
	}

	public function rightJoin($joinTable,$baseTableCol,$operator,$joinTableCol){
		$this->db->SetJoinStatement("RIGHT",$joinTable,$baseTableCol,$operator,$joinTableCol);
		return $this;	
	}
	
	public function crossJoin($joinTable){
		$this->db->SetJoinStatement("CROSS",$joinTable);
		return $this;	
	}

	public function hasOne($model,$baseTableIDCol="id",$relatedTableCol=null){
    	//Check $baseTableCol is sent or not
    	if($relatedTableCol==null)
    		$relatedTableCol=strtolower(static::class."_id");
		//Require proper model.php
		require_once '../app/models/' . $model . '.php';
		//Create object
		$object=new $model;
		$object=$object->where($relatedTableCol,$this->$baseTableIDCol)->first();
        return $object;
    }

    public function belongsTo($model,$baseTableCol=null,$relatedTableIDCol="id"){
    	//Check $baseTableCol is sent or not
    	if($baseTableCol==null)
    		$baseTableCol=strtolower($model."_id");
		//Require proper model.php
		require_once '../app/models/' . $model . '.php';
		//Create object
		$object=new $model;
		$object=$object->where($relatedTableIDCol,$this->$baseTableCol)->first();
        return $object;
    }
    public function hasMany($model,$baseTableIDCol="id",$relatedTableCol=null){
    	//Check $baseTableCol is sent or not
    	if($relatedTableCol==null)
    		$relatedTableCol=strtolower(static::class."_id");
		//Require proper model.php
		require_once '../app/models/' . $model . '.php';
		//Create object
		$object=new $model;
		$object=$object->where($relatedTableCol,$this->$baseTableIDCol)->get();
        return $object;
    } 

    public function belongsToMany($model,$pivotTable,$baseTableIDCol="id",$basePivotCol=null,$relatedTableIDCol="id",$relatedPivotCol=null){
    	// Check basePivotCol and $relPivotCol are sent or not:
    	if($basePivotCol==null)
    		$basePivotCol=strtolower(static::class)."_id";
    	if($relatedPivotCol==null)
    		$relatedPivotCol=strtolower($model."_id");

		//Require proper model.php
		require_once '../app/models/' . $model . '.php';
		$object=new $model;
		return $object->rawQuery("SELECT * FROM ".$object->table." WHERE ".$relatedTableIDCol." in (SELECT ".$relatedPivotCol." FROM ".$pivotTable." WHERE ".$basePivotCol."=".$this->$baseTableIDCol.")");
    } 

    public function hasManyThrough($throughModel,
    								$resultModel,
    								$baseTableIDCol="id",
    								$throughTableCol=null,
    								$throughTableIDCol="id",
    								$resultTableCol=null)
    {
    	// Check basePivotCol and $relPivotCol are sent or not:
    	if($throughTableCol==null)
    		$throughTableCol=strtolower(static::class)."_id";
    	if($resultTableCol==null)
    		$resultTableCol=strtolower($throughModel."_id");
    	

		//Require proper model.php
		require_once '../app/models/' . $throughModel . '.php';
		require_once '../app/models/' . $resultModel . '.php';

		$obj=new $resultModel;
		$throughObj=new $throughModel;

		//Query
		return  $obj->rawQuery("Select * from ".$obj->table." where ".$resultTableCol." IN (Select ".$throughTableIDCol." from ".$throughObj->table." where ".$throughTableCol."=".$this->$baseTableIDCol.")");
		// $resultObjects=array();

		// // Creating models for each query result
		// foreach($dbResults as $dbKey => $result){
		// 	//Create new model
		// 	$model=new $resultModel;
		// 	//Set dynamic parameters
		// 	foreach ($result as $key => $value) {
		// 		$model->$key=$value;
		// 	}
		// 	array_push($resultObjects,$model);
		// }

		// return $resultObjects;
    }
}

	

