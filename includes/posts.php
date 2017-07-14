<?php
	require_once('initialize.php');
	require_once(LIB_PATH.DS.'database.php');

	class Posts extends DatabaseObject{
		protected static $tablename = "posts";
		protected static $dbFields = array(	'id','thread','content','date','postby');
		public $id;
		public $content;
		public $thread;
		public $postby;
		public $date;

		public static function make($thread,$by, $content){
			global $database;
			if(!empty($thread) && !empty($by) && !empty($content)){
			$post = new Posts();
			$post->thread = $thread;
			$post->postby = $by;
			$post->content = $content;
			$s = "INSERT INTO " . static::$tablename ;
			$s .= "(thread, content, postby)" ;
			$s .= " values (" ;
			$s .= $thread . ",'" . $content . "'," . $by. ")";
			if($database->query($s)){
			  $post->id = $database->insertId();
			  return true;
			} else {
			return false;
		}
	}
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


		public static function findPostsOnThread($thread=0){
			global $database;
			$q = "SELECT * FROM " . self::$tablename;
			$q.= " WHERE thread=" .$database->escapeValue($thread);
			$q.= " ORDER BY date ASC";
			return self::findBySql($q);
		}

		public static function findPostsByThread($thread){
			global $database;
			$s = "SELECT thread,content,date,posts.postby,users.id,users.username ";
    		$s.= " FROM posts LEFT JOIN users ON posts.postby = users.id ";
    		$s.= " WHERE posts.thread= " . $thread;
    		//$posts = $database->query($s);
    		//return $posts;
    		return self::findBySql($s);
		}
	}




?>