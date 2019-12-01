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

   <title>Edit Blog | TECHSCIPEDIA</title>
   <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
</head>
<style>
.mce-tinymce {
margin: 0;
padding: 0;
display: block;
border: 1px solid #e3e3e3 !important;
border-top-left-radius: 3px !important;
border-top-right-radius: 3px !important;
border-bottom: 0px !important;
}
</style>
<body style="background-color: #e1e8ea;">
    <div class="container">
    <?php include('includes/header.php');?> 
        <div style="margin-top: 20px;">
                 
                <?php

                    //if form has been submitted process it
                    if(isset($_POST['submit'])){

                        //collect form data
                        extract($_POST);

                        //very basic validation
                        if($ediID ==''){
                            $error[] = 'This Editorial is missing a valid id!.';
                        }

                        if($ediTitle ==''){
                            $error[] = 'Please enter the title.';
                        }

                        if($ediDesc ==''){
                            $error[] = 'Please enter the description.';
                        }

                        if($ediCont ==''){
                            $error[] = 'Please enter the content.';
                        }

                        if(!isset($error)){

                            try {

                                $ediSlug = slug($ediTitle);

                                //insert into database
                                $stmt = $db->prepare('UPDATE editorialscitech SET ediTitle = :ediTitle,ediAuthor = :ediAuthor, ediSlug = :ediSlug, ediDesc = :ediDesc, ediCont = :ediCont WHERE ediID = :ediID') ;
                                $stmt->execute(array(
                                    ':ediTitle' => $ediTitle,
                                    ':ediAuthor' => $ediAuthor,
                                    ':ediSlug' => $ediSlug,
                                    ':ediDesc' => $ediDesc,
                                    ':ediCont' => $ediCont,
                                    ':ediID' => $ediID,
                                ));

                                //delete all items
                                $stmt = $db->prepare('DELETE FROM editagsscitech WHERE ediID = :ediID');
                                $stmt->execute(array(':ediID' => $ediID));

                                if(is_array($topID)){
                                    foreach($_POST['topID'] as $topID){
                                        $stmt = $db->prepare('INSERT INTO editagsscitech (ediID,topID)VALUES(:ediID,:topID)');
                                        $stmt->execute(array(
                                            ':ediID' => $ediID,
                                            ':topID' => $topID
                                        ));
                                    }
                                }
                                header('Location: delete-editorial(scitech).php?action=updated');
                                exit;
                                }

                            catch(PDOException $e) {
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

                            $stmt = $db->prepare('SELECT ediID,ediAuthor, ediTitle, ediDesc, ediCont,status FROM editorialscitech WHERE ediID = :ediID') ;
                            $stmt->execute(array(':ediID' => $_GET['id']));
                            $row = $stmt->fetch(); 

                        } catch(PDOException $e) {
                            echo $e->getMessage();
                        }

                    ?>
                
                <!-- /# row -->
                 <form class="form-horizontal form-material"  enctype="multipart/form-data" action='' method='post'>  
                <div class="row"> 
                 
                    <div class="col-lg-9">
                     <div class="card">
                        <div class="card-title">
                            <h4 align="center">Edit Blog</h4>
                        </div>
                        <div class="card-body">
                
                            <input type='hidden' name='ediID' value='<?php echo $row['ediID'];?>'>
                        
                        <div>
                            <div class="col-md-12">
                                <h4 class="card-title">Author</h4>
                                <input type="text" placeholder="Enter Author Name" class="form-control form-control-line" name='ediAuthor' value='<?php echo $row['ediAuthor'];?>'>
                            </div>
                        </div>
	                
                        <div>
                            <div class="col-md-12">
                                <h4 class="card-title">Name</h4>
                                <input type="text" placeholder="Enter post title" class="form-control form-control-line" name='ediTitle' value='<?php echo $row['ediTitle'];?>'>
                            </div>
                        </div>
                        
                     <div>
                        <div class="col-md-12">
                        <h4 class="card-title">Description</h4>
                        <textarea class="ckeditor" name='ediDesc'><?php echo $row['ediDesc'];?></textarea>
                        <script type="text/javascript">
                          CKEDITOR.replace( 'content' );
                        </script>
                         </div>
                     </div> 
                    
                    <div>
                        <div class="col-md-12">
                        <h4 class="card-title">Content</h4>
                        <textarea class="ckeditor" name='ediCont'><?php echo $row['ediCont'];?></textarea>
                        <script type="text/javascript">
                          CKEDITOR.replace( 'content' );
                        </script>
                        </div>
                     </div> 
                            
                            
                    <div class="form-group">
                        <div class="col-md-12">
                          <h4 class="card-title">Images</h4>
                                <input type="file" name="image" accept=".jpg,.jpeg,.png"/> 
                           </div>
                   </div>    
                            
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    
                    <div class="col-lg-3">
                        <div style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;"> 
                        <div class="container">
                                    <div class="col-sm-12" align="center">
                                        <button type="submit" name='submit' value='Submit' class="btn btn-success">Update</button>
                                    </div>
                                </div>
                        </div>
                    
                    <div style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;"> 
                        <div class="container">
                                <h4 align="center">Tags</h4>                           
                                <?php

                                $sql = 'SELECT topID, topTitle FROM tagsscitech ORDER BY topTitle';
                                $qry = $db->prepare($sql);
                                $qry->bindParam(':topID',$topID,PDO::PARAM_STR);
                                $qry->bindParam(':topTitle',$topTitle,PDO::PARAM_STR);
                                $qry->execute();
                                $result=$qry->fetchAll(PDO::FETCH_OBJ);
                                foreach ($result as $rslt){
                    
                                    if(isset($_POST['topID'])){
                    
                                        if(in_array($rslt->topID, $_POST['topID'])){
                                           $checked="checked='checked'";
                                        }else{
                                           $checked = null;
                                        }
                                    }
                                    echo "<label><input type='checkbox' name='topID[]' value='".$rslt->topID."'> ".$rslt->topTitle."</label><br />";
                                }

                                ?>

                        </div>
                    </div>
                    
                     </div>
                    
                    
                </div>
                <!-- /# row -->
                </form>
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