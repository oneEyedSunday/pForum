<?php
	require_once('initialize.php');
	require_once(LIB_PATH.DS.'database.php');
	require_once('databaseObject.php');

	class User extends DatabaseObject{
		public $id;
		public $username;
		public $hashedPassword;
		public $firstName;
		public $lastName;
		public $email;
		public $avatar_path;


		protected static $tablename = "users";  
		protected static $dbFields = array('id','username','hashedPassword','firstName','lastName','email','avatar_path');


		public function fullName(){
			if(isset($this->firstName) && isset($this->lastName)){
			    return $this->firstName . " " . $this->lastName; 
			  } else {
			    return "";
			  }
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

		protected function sanitizedAttributes(){
	       global $database;
	       $cleanAttributes = array();
	       foreach($this->attributes() as $key => $value){
	    		$cleanAttributes[$key] = $database->escapeValue($value);
	  		}
	  		return $cleanAttributes;
		}


		public static function authenticate($usercred = "", $password= ""){
			global $database;
			$usercred = $database->escapeValue($usercred);
			$password = $database->escapeValue($password);
			$hashedPassword = sha1($password);
			$q = "SELECT * from users ";
			$q .= " WHERE username = '{$usercred}' ";
			$q .= " OR email = '{$usercred}' ";
			$q .= " AND hashedpassword = '{$hashedPassword}' limit 1 ";
			$resultArray = self::findBySql($q);
			return !empty($resultArray) ? array_shift($resultArray) : false;
			//return $q;
		}

		protected function create(){
			global $database;
			$attributes = $this->sanitizedAttributes();
			$attributes['hashedPassword'] = sha1($this->hashedPassword);
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

		protected function update(){
		  global $database;
		  $attributes = $this->sanitizedAttributes();
		  $attributePairs = array();
		  foreach($attributes as $key => $value){
		    $attributePairs[] = "{$key}='{$value}'";
		  }
		  $attributes['hashedPassword'] = sha1($this->hashedPassword);
		  $sql = "update " .static::$tablename. " set " ;
		  $sql .= join(", ", $attributePairs);
		  $sql .= " where id=" .$database->escapeValue($this->id);
		  $database->query($sql);
		  if($database->affectedRows() == 1){
		    return true;
		  } else {return false;}
		}

		public function save(){
  			//new record wont have id
	  		return isset($this->id) ? $this->update() : $this->create();
		}

		public function delete(){
  			global $database;
  			$sql = "delete from " . static::$tablename;
  			$sql .= " where id=" .$database->escapeValue($this->id);
  			$sql .= " limit 1";
  			$database->query($sql);
  			if($database->affectedRows() == 1){
    			return true;
  			} else {return false;}
		}


	}


	// $newuser = new User();
	// $newuser->firstName = "First";
	// $newuser->lastName = "Last";
	// $newuser->username = "user_001";
	// $newuser->password = "secret";
	// $newuser->email    = "errata@prog.dev";
	// $newuser->save();


?>