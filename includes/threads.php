<?php
require_once('initialize.php');
require_once(LIB_PATH.DS."database.php");

class Threads extends DatabaseObject{
protected static $tablename = "threads";  
protected static $dbFields = array(	'id','title','date','category','owner');
public $id;
public $category;
public $owner;
public $title;
public $date;


		protected function create(){
			global $database;
			$attributes = $this->sanitizedAttributes();
			unset($attributes['id']);
			unset($attributes['date']);
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

		public static function findThreadsByCat($catid){
			$q = "SELECT * FROM threads ";
			$q .= "WHERE category = " . $catid;
			$topicSet =  self::findBySql($q);
			return $topicSet;
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


}


// $t = new Threads();
// $t->category = 1;
// $t->owner = 3;
// $t->title = "Test";
// //$t->date = "Now()";
// $t->save();

?>