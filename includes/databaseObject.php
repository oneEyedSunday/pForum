<?php
	require_once(LIB_PATH.DS.'database.php');

	class DatabaseObject{
		protected static $tablename;

		public static function findAll(){
			$q = "SELECT * from " .static::$tablename;
			$resultSet = self::findBySql($q);
			return $resultSet;
		}

		public static function findById($id = 1){
			//static cos of its gonna be called by a child
			//so lSB can be called
			//instaed of (get_class(self))::$tablename

			$q = "SELECT * from ".static::$tablename;
			$q .= " WHERE id={$id} limit 1";
			$resultArray = self::findBySql($q);
			return !empty($resultArray) ? array_shift($resultArray) : false;
		}

		public static function findBySql($sql=""){
			global $database;
			$resultSet = $database->query($sql);
			$objectArray = array();
			while($row = $database->fetchArray($resultSet)){
				$objectArray[] = self::instantiate($row);
			}
			return $objectArray;
		}

		private static function instantiate($record){
			//lsb advantage?
			$cc = get_called_class();
			$object = new $cc;
			foreach($record as $attribute=>$value){
				if($object->hasAttribute($attribute)){
					$object->$attribute = $value;
				}
			}
			//hash pword?
			return $object;
		}

		private function hasAttribute($attribute){
			$objectVars = get_object_vars($this);
			return array_key_exists($attribute, $objectVars);
		}
	}


?>