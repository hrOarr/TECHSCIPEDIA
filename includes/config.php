<?php 
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','bookpalace');
try
{
	$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

function __autoload($class) {
   
   $class = strtolower($class);

   //if call from within assets adjust the path
   $classpath = 'sa_core/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }  
   
   //if call from within admin adjust the path
   $classpath = '../sa_core/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }
   
   //if call from within admin adjust the path
   $classpath = '../../sa_core/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
   }     
    
}
   
     include('functions.php');
}
catch (PDOException $e)
{
	exit("error: " . $e->getMessage());
}
?>