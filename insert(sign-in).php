<?php
session_start();
include('includes/config.php');
if(isset($_POST['submit']))
{
$username=$_POST['username'];
$password=($_POST['password']);
$sql ="SELECT Username,Password FROM user WHERE Username=:username and Password=:password";
$query= $db->prepare($sql);
$query->bindParam(':username', $username, PDO::PARAM_STR);
$query->bindParam(':password', $password, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount()>0)
{
$_SESSION['login']=$_POST['username'];
echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}
else echo "<script>alert('Wrong Username or Password!');</script>";
}

?>
