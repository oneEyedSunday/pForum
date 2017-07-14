<?php 
//define core paths as absolutes
//(\ windows / unix) 
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
 define('SITE_ROOT', 'C:'.DS.'wamp64'. DS. 'www'. DS. 'pforum');

defined('LIB_PATH')? null : 
 define('LIB_PATH', SITE_ROOT.DS.'includes');
//LOAD CONFIG FILE FIRST
require_once(LIB_PATH.DS."config.php");
//LOAD BASIC FUNCTIONS
//require_once(LIB_PATH.DS."functions.php");
//LOAD CORE OBJECTS
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."databaseObject.php");
//LOAD DB RELATED CLASSES
require_once(LIB_PATH.DS."user.php");
//require_once(LIB_PATH.DS."logger.php");
require_once(LIB_PATH.DS."categories.php");
require_once(LIB_PATH.DS."threads.php");
require_once(LIB_PATH.DS."posts.php");



function redirect_to($new){
  header("Location: " .$new);
  exit;
}

?>