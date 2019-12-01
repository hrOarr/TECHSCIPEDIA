<?php
session_start();
$message="";
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
if(isset($_SESSION['url'])) 
   $url = $_SESSION['url'];
else 
   $url = "blogs_scitech.php";
header('Location: '.$url.'');
}
else $message = "Invalid Username or Password!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>ok</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>

<style type="text/css">
    input[type=text], input[type=password] {
  width: 100%;
  padding: 5px;
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
<?php include('includes/header.php');?>
  <p style="font-weight: bold;margin-top: 40px;">Fill in the form to signin into TECHSCIPEDIA.</p>
  <div class="container col-md-6 col-xs-6" style="padding-top: 10px;">
 <form action="" method="post" name="vform" onsubmit="return Validate()" style="border:1px solid #ccc">
  <div class="message" align="center"><?php if($message!="") { echo $message; } ?></div>
  <div class="container">
    <p style="font-weight: bold;color: #074861;font-size: 23px;">Signin into TECHSCIPEDIA</p>
    <hr>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username">
    <div id="username_div">
    <div id="name_error"></div>
    </div>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password">
    <div id="password_div">
      <div id="password_error"></div>
    </div>
    
    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>

    <div class="form-group" align="center">
        <div class="row">
    <div class="col-md-2 col-xs-4">
     <button type="submit" name="submit" class="btn" value="submit" style="cursor:pointer;" align="center">Submit</button>
 </div>
 <div class="col-md-10 col-xs-8">
     New user?<a href="sign-up(user).php" style="text-decoration: underline;">Register</a>
    </div>
</div>
</div>
  </div>
</form>
</div>

<?php include('includes/footer.php');?>
</div>

    <script src="form-validation(signin).js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>