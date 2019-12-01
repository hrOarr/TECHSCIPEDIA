<?php
error_reporting(0);
include('../includes/config.php');
$message="";
if(isset($_POST['submit']))
{
$username=$_POST['username'];
$sql = "SELECT * from admins where Username=:username";
$qry = $db->prepare($sql);
$qry->bindParam(':username',$username,PDO::PARAM_STR);
$qry->execute();
$result=$qry->fetchAll(PDO::FETCH_OBJ);
echo $qry->rowCount();
if($qry->rowCount()>0)$message="Username already exists!";
else 
{
$username=$_POST['username'];
$email=$_POST['email'];
$password=$_POST['password'];
$stmt=$db->prepare("INSERT INTO admins(Username,Email,Password) VALUES(:username,:email,:password)");
$stmt->execute(array(':username' => $username,':email' => $email,':password' => $password));
$lastInsertId = $db->lastInsertId();
if($lastInsertId)header('Location: index.php');
else echo "<script>alert('Something went wrong!Try again.');</script>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Sign up(admin) | TechSci Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>

<style type="text/css">
    input[type=text], input[type=password] {
  width: 100%;
  padding: 7px;
  display: inline-block;
  border: 1px solid #ccc;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: white;
  outline: none;
}

hr {
  border: 0.5px solid #ccc;
  padding-top: 0px;
}
.message{
  color: red;
}

</style>

<body>
<div class="container">
  <p style="font-weight: bold;margin-top: 40px;">Fill in the form to signup into TECHSCIPEDIA(admin).</p>
  <div class="container col-md-6 col-xs-6" style="padding-top: 10px;">
 <form action="" method="post" name="vform" onsubmit="return Validate()" style="border:1px solid #ccc;">
  <div class="message" align="center"><?php if($message!="") { echo $message; } ?></div>
  <div class="container">
    <p style="font-weight: bold;color: #074861;font-size: 23px;">Signup into Bookpalace</p>
    <hr>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username">
    <div id="username_div">
    <div id="name_error"></div>
    </div>
    
    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email">
    <div id="email_div">
      <div id="email_error"></div>
    </div>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password">
    <div id="password_div">
      <div id="password_error"></div>
    </div>

    </label>
    <div class="form-group" align="center">
        <div class="row" style="margin-top: 10px;">
    <div class="col-md-3 col-xs-12">
     <button type="submit" name="submit" class="btn" value="submit" style="cursor:pointer;" align="center">Register</button>
 </div>
 <div class="col-md-9 col-xs-12">
     Already admin?<a href="login.php" style="text-decoration: underline;">Sign In</a>
    </div>
</div>
</div>
  </div>
</form>
</div>

</div>
    <script src="../form-validation.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>