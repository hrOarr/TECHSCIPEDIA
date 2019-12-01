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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>Edit tag | TechSci Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>

<body style="background-color: #e1e8ea;">
        <?php include('includes/header.php');?> 
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
                                if($topID ==''){
                                    $error[] = 'This editorial is missing a valid id!.';
                                }

                                if($topTitle ==''){
                                    $error[] = 'Please enter the title.';
                                }

                                if(!isset($error)){

                                    try {

                                        $catSlug = slug($topTitle);

                                        //insert into database
                                        $stmt = $db->prepare('UPDATE tagsscitech SET topTitle = :topTitle, topSlug = :topSlug WHERE topID = :topID') ;
                                        $stmt->execute(array(
                                            ':topTitle' => $topTitle,
                                            ':topSlug' => $topSlug,
                                            ':topID' => $topID
                                        ));

                                        //redirect to index page
                                        header('Location: delete-subject(scitech).php?action=updated');
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

                                    $stmt = $db->prepare('SELECT topID, topTitle FROM tagsscitech WHERE topID = :topID') ;
                                    $stmt->execute(array(':topID' => $_GET['id']));
                                    $row = $stmt->fetch(); 

                                } catch(PDOException $e) {
                                    echo $e->getMessage();
                                }

                            ?>

		        
                                            <div class="card-body">

                                                 <form class="form-horizontal form-material" method='post'>
                                                     
                                                     <input type='hidden' name='topID' value='<?php echo $row['topID'];?>'>
                                                     
                                                    <div class="form-group">
                                                        <label class="col-md-12">Name</label>
                                                        <div class="col-md-12">
                                                            <input type="text" name='topTitle' value='<?php echo $row['topTitle'];?>' placeholder="Enter Subject Name" class="form-control form-control-line">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button type="submit" name='submit' value='Update' class="btn btn-danger">Update</button>
                                                        </div>
                                                    </div>
                                                </form>

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