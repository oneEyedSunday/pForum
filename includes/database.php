<?php
	require_once('initialize.php');

	class MySQLDatabase{
		private $conn;
		public $lastQuery;

		function __construct(){
			$this->openConn();
		}

		public function openConn(){
			$this->conn = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBDATABASE);
			if(!$this->conn){
				die("Database connection failed: ". mysqli_connect_error());
			}
		}

		public function closeConn(){
			if(isset($this->conn)){
				mysqli_close($this->conn);
				unset($this->conn);
			}
		}

		public function query($sql){
			//set last query to present query
			//for debug purposes 
			$this->lastQuery = $sql;
			$result = mysqli_query($this->conn, $sql);
			$this->confirmQuery($result);
			return $result;
		}

		private function confirmQuery($result){
			if(!$result){
				$output = "Database query failed: ".mysqli_error($this->conn)."<br/><br/>";
				$output .= "Last SQL query: " .$this->lastQuery;
				die($output);
			}
		}

		public function escapeValue($value){
			$value = mysqli_real_escape_string($this->conn, $value);
			return $value;
		}

		public function fetchArray($resultSet){
			return mysqli_fetch_array($resultSet /*, $this->conn*/);
		}

		public function fetchAssoc($resultSet){
			return mysqli_fetch_assoc($resultSet);
		}

		public function numRows($resultSet){
			return mysqli_num_rows($resultSet /*, $this->conn*/);
		}

		public function insertId(){
			return mysqli_insert_id($this->conn);
		}

		public function affectedRows(){
			return mysqli_affected_rows($this->conn);
		}
	}

	$database = new MySQLDatabase();




?>