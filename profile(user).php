<?php
session_start();
include('includes/config.php');
$_SESSION['url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$current_user = $_GET['user'];
$stmt = $db->prepare('SELECT * FROM user WHERE Username = :Username ');
$stmt->execute(array(':Username' => $current_user));
$row = $stmt->fetch();
//$picture = $row['picture'];
//$Fullname = $row['Fullname'];
//$Email = $row['Email'];
//$Location = $row['Location'];
//$Reg_date = $row['Regtime'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Profile - <?php echo $current_user; ?> | TECHSCIPEDIA</title>
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

<body style="background-color: #d2dadf;">
<div class="container">
<?php include('includes/header.php');?>
     <div class="container" style="margin-top: 30px;background-color: #fff;">
            <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <div class="container" align="center" style="margin-top: 20px;margin-bottom:20px;background-color: #fff;">
                          <?php
                           if(!$row['picture']){
                            echo "<img src='image/default-avatar.jpg' width='200px' height='200px' style='border-radius: 50%;' alt='img'/>";
                           }
                           else{
                            ?>
                            <img src='<?php echo 'image/'.$row['picture'];?>' width='200px' height='200px' style='border-radius: 50%;' alt='img'/>
                            <?php
                          }
                           echo "</br></br>";
                           echo "<h5 style='color: #8181e5;'>".$current_user."</h5>";
                           echo "</br>";
                          ?>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                        <div class="container" style="margin-top: 20px;margin-bottom:20px;background-color: #fff;">
                          <h5>Saved details</h5>
                          <hr>
                          <?php
                           if(!$row['Fullname'])$row['Fullname']="(not set yet)";
                           if(!$row['Location'])$row['Location']="(not set yet)";
                           echo "<span style='font-family: serif;font-size:20px;'>Name : </span>".$row['Fullname']."</br>";
                           echo "<span style='font-family: serif;font-size:20px;'>Location : </span>".$row['Location']."</br>";

                              $tim = abs(time() - strtotime($row['Regtime']));
                              $min = $tim; $da = $tim;
                              $minutes = ceil($tim/60);
                              $hours = ceil($min/(60*60));
                              $days = ceil($da/(60*60*24));
                              if($minutes<=300)
                              {
                                if($minutes==1){
                               echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$minutes </b><span> minute ago </span>";
                              }
                              else{
                                echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$minutes</b><span> minutes ago</span>";
                              }
                              }
                              else if($hours<=72)
                              {
                                if($hours==1){
                              echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$hours</b><span> hour ago </span>";
                              }
                              else{
                                echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$hours
                                </b><span> hours ago</span>";
                              }
                              }
                              else 
                              {
                              if($days<365){
                              if($days==1){
                              echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$days </b><span> day ago </span>";
                              }
                              else{
                                echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$days
                                </b><span> days ago</span>";
                              }
                              }
                              else{
                                $days = $days/365;
                                if($days==1){
                                echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$days </b><span> year ago </span>";
                              }
                              else{
                                echo "<span style='font-family: serif;font-size:20px;'>Registered : </span><b style='font-weight:bold;'>$days </b><span> years ago </span>";
                              }
                              }
                            }
                          ?>
                        </div>
                    </div>
            </div>
      </div>
<?php include('includes/footer.php');?>
</div>

    <script src="form-validation(signin).js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>