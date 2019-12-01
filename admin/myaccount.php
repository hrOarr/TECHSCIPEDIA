<?php //include config
include('../includes/config.php');

if(!$_SESSION['username']){ header('Location: login.php'); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>profile | TechSci Room</title>
    
 <script language="JavaScript" type="text/javascript">
  function deladmin(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'users.php?deladmin=' + id;
	  }
  }
  </script>

</head>

<body>
            <div class="container" style="margin-top: 20px;">
                
                <div class="row">
				    <div class="col-lg-12">
                        <div class="card">

                            <?php

                            //if form has been submitted process it
                            if(isset($_POST['submit'])){

                                //collect form data
                                extract($_POST);

                                //very basic validation
                                if($username ==''){
                                    $error[] = 'Please enter the username.';
                                }

                                if( strlen($password) > 0){

                                    if($password ==''){
                                        $error[] = 'Please enter the password.';
                                    }

                                    if($passwordConfirm ==''){
                                        $error[] = 'Please confirm the password.';
                                    }

                                    if($password != $passwordConfirm){
                                        $error[] = 'Passwords do not match.';
                                    }

                                }


                                if($email ==''){
                                    $error[] = 'Please enter the email address.';
                                }

                                if(!isset($error)){

                                    try {
                                            //update database
                                            $stmt = $db->prepare('UPDATE admins SET username = :username, email = :email WHERE memberID = :memberID') ;
                                            $stmt->execute(array(
                                                ':username' => $username,
                                                ':email' => $email,
                                                ':memberID' => $memberID
                                            ));

                                        //redirect to index page
                                        header('Location: users.php?action=updated');
                                        exit;

                                    } catch(PDOException $e) {
                                        echo $e->getMessage();
                                    }

                                }

                            }

                            ?>


                            <?php
                            //check for any errors
                            if(isset($error)){
                                foreach($error as $error){
                                    echo $error.'<br />';
                                }
                            }

                                try {

                                    $stmt = $db->prepare('SELECT memberID, username, email FROM sa_users WHERE memberID = :memberID') ;
                                    $stmt->execute(array(':memberID' => $_GET['id']));
                                    $row = $stmt->fetch(); 

                                } catch(PDOException $e) {
                                    echo $e->getMessage();
                                }

                            ?>
                            
                               
                            <div class="card-body">
                                        <form class="form-horizontal form-material" method='post'>
                                            
                                            <input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>
              
                                            <div class="form-group">
                                                <label class="col-md-12">Username</label>
                                                <div class="col-md-12">
                                                    <input type="text" name='username' value='<?php echo $row['username'];?>' placeholder="Enter Username" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="example-email" class="col-md-12">Email</label>
                                                <div class="col-md-12">
                                                    <input type="email" name='email' value='<?php echo $row['email'];?>' placeholder="Enter Email ID" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Password (only to change)</label>
                                                <div class="col-md-12">
                                                    <input type="password" name='password' value='' placeholder="Enter Password" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12">Confirm Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" name='passwordConfirm' value='' placeholder="Enter Confirm Password" class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <button type="submit" name='submit' value='Update User' class="btn btn-success">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            
                        </div>
                    </div>
                </div>



                </div>


                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> Copyrights &copy; <?php echo date("Y"); ?> <a href="http://softaox.info/" target="_blank">softAOX.info</a>. All Rights Reserved.</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    
     <!-- Java Scripts -->
           <?php include('includes/js.php');?> 
     <!-- End Java Scripts -->

</body>

</html>