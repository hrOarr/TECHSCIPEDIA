<?php
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit']))
{
$username=$_POST['username'];
$sql = "SELECT * from user where Username=:username";
$qry = $db->prepare($sql);
$qry->bindParam(':username',$username,PDO::PARAM_STR);
$qry->execute();
$result=$qry->fetchAll(PDO::FETCH_OBJ);
echo $qry->rowCount();
if($qry->rowCount()>0)header("Location: sign-up(user).php?message=User name already exists.");
else 
{
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$conpass=$_POST['conpass'];
$sql="INSERT INTO user(Username,Email,Password,ConfirmPassword) VALUES(:username,:email,:password,:conpass)";
$query = $db->prepare($sql);
$query->bindParam(':username',$username,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':conpass',$conpass,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $db->lastInsertId();
if($lastInsertId)header('Location: index.php');
else echo "<script>alert('Wrong Username or Password!');</script>";
}
}
?>