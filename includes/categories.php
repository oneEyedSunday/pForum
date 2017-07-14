<?php
require_once('initialize.php');
require_once(LIB_PATH.DS."database.php");

class Categories extends DatabaseObject{
protected static $tablename = "categories";  
protected static $dbFields = array('id','categoryname','categorydescription','visibility');//'position',
public $id;
public $categoryname;
//public $position;
public $visibility = 1;
public $categorydescription;


		protected function create(){
			global $database;
			$attributes = $this->sanitizedAttributes();
			unset($attributes['id']);
			$sql = "INSERT into " .static::$tablename. "(";
			$sql .= join(", ", array_keys($attributes));
			$sql .= ") values ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "')";
			if($database->query($sql)){
			  $this->id = $database->insertId();
			  return true;
			} else {
			return false;
  			}
		}


		public function save(){
  			//new record wont have id
	  		return $this->create();
		}

		protected function sanitizedAttributes(){
	       global $database;
	       $cleanAttributes = array();
	       foreach($this->attributes() as $key => $value){
	    		$cleanAttributes[$key] = $database->escapeValue($value);
	  		}
	  		return $cleanAttributes;
		}


		protected function attributes(){
			$attributes = array();
			foreach (self::$dbFields as $field) {
			    if(property_exists($this, $field)){
			        $attributes[$field] = $this->$field;
			    }
			  }
			  return $attributes;
		}


		public function findLastTopic(){
			global $database;
			$sql = "SELECT title from threads where category= ". $this->id . " ORDER by date desc LIMIT 1";
			$resultSet = $database->query($sql);
			//$result_set = mysqli_query($conn,$sql);
			if($database->numRows($resultSet) == 0){
				return "No Topics to Show";
			}else{
				$rsr = $database->fetchAssoc($resultSet);
				return $rsr['title'];
			}

		}


}


// $c = new Categories();
// $c->categoryname = "General";
// $c->position = 1;
// $c->visibility = 1;
// $c->categorydescription = "For random topics";
// $c->save();

?>