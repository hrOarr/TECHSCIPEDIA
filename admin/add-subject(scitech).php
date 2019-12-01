<?php //include config
session_start();
include('../includes/config.php');
if(!$_SESSION['username']){ header('Location: login.php'); }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Add New Tag | TECHSCIPEDIA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>

<body style="background-color: #e1e8ea;">
    <div class="container">
    <?php include('includes/header.php');?> 
    <div style="margin-top: 20px;">
                <div class="row" style="padding-top: 15px;padding-bottom: 15px;">
				    <div class="col-lg-12">
                        <div class="card">

                            <?php

                            //if form has been submitted process it
                            if(isset($_POST['submit'])){

                                //collect form data
                                extract($_POST);

                                //very basic validation
                                if($topTitle ==''){
                                    $error[] = 'Please enter the tag.';
                                }

                                if(!isset($error)){

                                    try {

                                        $topSlug = slug($topTitle);

                                        //insert into database
                                        $stmt = $db->prepare('INSERT INTO tagsscitech (topTitle,topSlug) VALUES (:topTitle, :topSlug)') ;
                                        $stmt->execute(array(
                                            ':topTitle' => $topTitle,
                                            ':topSlug' => $topSlug
                                        ));

                                        //redirect to categories page
                                        header('Location: add-subject(scitech).php?action=added');
                                        exit;

                                    } catch(PDOException $e) {
                                        echo $e->getMessage();
                                    }

                                }

                            }

                            //check for any errors
                            if(isset($error)){
                                foreach($error as $error){
                                    echo '<p class="error">'.$error.'</p>';
                                }
                            }
                            ?>

                            
                          
                            
                                            <div class="card-body">

                                                 <form class="form-horizontal form-material" method='post'>
                                                    <div class="form-group">
                                                        <label class="col-md-12">Name</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name='topTitle' value='<?php if(isset($error)){ echo $_POST['topTitle'];}?>' placeholder="Enter Tag Name" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button type="submit" name='submit' value='Add User' class="btn btn-primary">Add New Tag</button>
                                                        </div>
                                                    </div>
                                                </form>

                                    </div>
                         
                        </div>
                    </div>
                </div>
            </div>
</div>
    <!-- Java Scripts -->
           <?php include('includes/js.php');?> 
     <!-- End Java Scripts -->
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

</html>