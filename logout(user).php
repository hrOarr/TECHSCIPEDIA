<?php  
session_start();  
$_SESSION['profile'] = $_SESSION['login'];
$_SESSION['login'] = ""; 
if(isset($_SESSION['url'])) 
   $url = $_SESSION['url'];
else 
   $url = "blogs_scitech.php";
header('Location: '.$url.'');
?>  