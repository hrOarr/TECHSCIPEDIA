<?php
session_start();
$msg = "";
$msg_class = "";
include('includes/config.php');
$_SESSION['url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$current_user = $_GET['user'];
$stmt = $db->prepare('SELECT * FROM user WHERE Username = :Username ');
$stmt->execute(array(':Username' => $current_user));
$row = $stmt->fetch();

if(isset($_POST['submit'])){
    $profileImageName =  $_FILES["profileImage"]["name"];
    // For image upload
    $target_dir = "image/";
    $Fullname = $_POST['Fullname'];
    $Location = $_POST['Location'];
    $target_file = $target_dir . basename($profileImageName);
    // VALIDATION
    // validate image size. Size is calculated in Bytes
    if($_FILES['profileImage']['size'] > 200000) {
      $msg = "Image size should not be greated than 200Kb";
      $msg_class = "alert-danger";
    }
    // check if file exists
    if(file_exists($target_file)) {
      $msg = "File already exists";
      $msg_class = "alert-danger";
    }

    if (empty($error)) {
      $conn = mysqli_connect("localhost", "root", "", "bookpalace");
      if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {
        $sql = "UPDATE user SET Fullname = '$Fullname', picture = '$profileImageName', Location = '$Location' WHERE Username = '$current_user' ";
        if(mysqli_query($conn, $sql)){
          $msg = "Data is updated successfully";
          $msg_class = "alert-success";
        }
        else {
          $msg = "Something went wrong.Try again later.";
          $msg_class = "alert-danger";
        }
      }
    }
    else {
      $error = "There was an error uploading the file";
      $msg = "alert-danger";
    }
}
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

#profileDisplay { display: block; height: 200px; width: 200px; margin: 0px auto; border-radius: 50%; }
.img-placeholder {
  width: 200px;
  color: white;
  height: 200px;
  background: black;
  opacity: .6;
  height: 200px;
  border-radius: 50%;
  z-index: 2;
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  display: none;
}
.img-placeholder h4 {
  margin-top: 40%;
  color: white;
}
.img-div:hover .img-placeholder {
  display: block;
  cursor: pointer;
}

</style>

<body style="background-color: #d2dadf;">
<div class="container">
<?php include('includes/header.php');?>
     <div class="container" style="margin-top: 30px;background-color: #fff;">
          <h5><?php echo $_SESSION['login'];?>'s profile settings</h5>
          <form class="form-horizontal form-material" action='' method='post' enctype="multipart/form-data">
            <?php if (!empty($msg)): ?>
            <div class="alert <?php echo $msg_class ?>" role="alert">
              <?php echo $msg; ?>
            </div>
           <?php endif; ?>
            <div class="row">
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <div class="container" align="center" style="margin-top: 20px;margin-bottom:20px;background-color: #fff;">
                          
            <span class="img-div">
              <div class="text-center img-placeholder"  onClick="triggerClick()">
                <h4>Update image</h4>
              </div>
              <?php
                if(!$row['picture'])$row['picture'] = "image/default-avatar.jpg";
              ?>
              <img src="<?php echo 'image/'.$row['picture'];?>" onClick="triggerClick()" id="profileDisplay">
            </span>
            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
            <label>Profile Image</label>
                        </div>
                        <div id="message"></div>
                    </div>
                    <div class="col-md-7 col-sm-7 col-xs-7">
                        <div class="container" style="margin-top: 20px;margin-bottom:20px;background-color: #fff;">
                            <label style="font-family: serif;font-size: 20px;">Name :</label>
                            <input type="text" name="Fullname" value="<?php echo $row['Fullname']; ?>" /><br>

                            <label style="font-family: serif;font-size: 20px;">Location :</label>
                            <input type="text" name="Location" value="<?php echo $row['Location']; ?>" /><br>
                        </div>
                    </div>
            </div>
            <button type="submit" name="submit" value="Submit" style="margin-bottom: 10px;cursor: pointer;">Save changes</button>
          </form>
      </div>
<?php include('includes/footer.php');?>
</div>

<script type="text/javascript">
  function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    var file = e.files[0];
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
    {
     $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h5>Note</h5>"+"<span id='error_message'>Only jpeg, jpg and png Images type is allowed</span>");
    }
    else
   {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}
}
</script>

    <script src="form-validation(signin).js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>