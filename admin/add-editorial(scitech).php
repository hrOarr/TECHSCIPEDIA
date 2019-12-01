<?php 
session_start();
//include config
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

    <title>Add New Blog(scitech) | TECHSCIPEDIA</title>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    
<style>
/* Custom CSS */
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
</head>

<body style="background-color: #e1e8ea;">
    <div class="container">
    <?php include('includes/header.php');?> 
    <div style="margin-top: 20px;">
                 
                <?php

                    //form has been submitted
                    if(isset($_POST['submit'])){

                        //collect form data
                        extract($_POST);

                        //very basic validation
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
                                $status = 1;
                                
                                //insert into database
                                $stmt = $db->prepare('INSERT INTO editorialscitech (ediTitle,ediAuthor,ediSlug,ediDesc,ediCont,ediDate,status) VALUES (:ediTitle,:ediAuthor, :ediSlug, :ediDesc, :ediCont, :ediDate,:status)') ;
                                $stmt->execute(array(
                                    ':ediTitle' => $ediTitle,
                                    ':ediAuthor' => $ediAuthor,
                                    ':ediSlug' => $ediSlug,
                                    ':ediDesc' => $ediDesc,
                                    ':ediCont' => $ediCont,
                                    ':ediDate' => date('Y-m-d H:i:s'),
                                    ':status' => $status,
                                ));
                                $ediID = $db->lastInsertId();
                               // if($ediID)echo "Inserted";
                               // else echo "Not";

                                //add subjects
                                if(is_array($topID)){
                                    foreach($_POST['topID'] as $topID){
                                        $stmt = $db->prepare('INSERT INTO editagsscitech (ediID,topID)VALUES(:ediID,:topID)');
                                        $stmt->execute(array(
                                            ':ediID' => $ediID,
                                            ':topID' => $topID
                                        ));
                                    }
                                }

                                //redirect to index page
                                header('Location: add-editorial(scitech).php?action=published');
                                exit;

                            } catch(PDOException $e) {
                                echo $e->getMessage();
                            }

                        }

                    }


                    if(isset($_POST['submit2'])){

                        //collect form data
                        extract($_POST);

                        //very basic validation
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
                                $status = 0;
                                
                                //insert into database
                                $stmt = $db->prepare('INSERT INTO editorialscitech (ediTitle,ediAuthor,ediSlug,ediDesc,ediCont,ediDate,status) VALUES (:ediTitle,:ediAuthor, :ediSlug, :ediDesc, :ediCont, :ediDate,:status)') ;
                                $stmt->execute(array(
                                    ':ediTitle' => $ediTitle,
                                    ':ediAuthor' => $ediAuthor,
                                    ':ediSlug' => $ediSlug,
                                    ':ediDesc' => $ediDesc,
                                    ':ediCont' => $ediCont,
                                    ':ediDate' => date('Y-m-d H:i:s'),
                                    ':status' => $status,
                                ));
                                $ediID = $db->lastInsertId();
                               // if($ediID)echo "Inserted";
                               // else echo "Not";

                                //add subjects
                                if(is_array($topID)){
                                    foreach($_POST['topID'] as $topID){
                                        $stmt = $db->prepare('INSERT INTO editagsscitech (ediID,topID)VALUES(:ediID,:topID)');
                                        $stmt->execute(array(
                                            ':ediID' => $ediID,
                                            ':topID' => $topID
                                        ));
                                    }
                                }


                                //redirect to index page
                                header('Location: add-editorial(scitech).php?action=drafted');
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
                
                <!-- /# row -->
                 <form class="form-horizontal form-material" action='' method='post' enctype="multipart/form-data">  
                <div class="row">
                 
                    <div class="col-md-9">
                     <div class="card">
                        <div class="card-title">
                            <h4 align="center">New Blog</h4>
                        </div>
                        <div class="card-body">

                        <div class="form-group">
                            <div class="col-md-12">
                                 <h4 class="card-title">Author</h4>
                                <input type="text" placeholder="Enter Author Name" class="form-control form-control-line" name='ediAuthor' value='<?php if(isset($error)){ echo $_POST['ediAuthor'];}?>'>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-md-12">
                                 <h4 class="card-title">Name</h4>
                                <input type="text" placeholder="Enter post title" class="form-control form-control-line" name='ediTitle' value='<?php if(isset($error)){ echo $_POST['ediTitle'];}?>'>
                            </div>
                        </div>
                        
                      <div class="form-group">
                        <div class="col-md-12">
                        <h4 class="card-title">Description</h4>
                        <textarea class="ckeditor" name='ediDesc'><?php if(isset($error)){ echo $_POST['ediDesc'];}?></textarea>
                        <script type="text/javascript">
                  CKEDITOR.replace( 'content' );
                </script>
                        </div>
                     </div>
                            
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4 class="card-title">Content</h4>
                         <textarea class="ckeditor" name='ediCont'><?php if(isset($error)){ echo $_POST['ediCont'];}?></textarea>
                         <script type="text/javascript">
                  CKEDITOR.replace( 'content' );
                </script>
                         </div>
                     </div> 
                            
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4 class="card-title">Images</h4>
                                <input type="file" name="img" accept=".jpg,.jpeg,.png"/> 
                           </div>
                      </div>      
            
                            
                            
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                    
                    <div class="col-md-3">
                      
                       <div style="margin-top: 20px;"> 
                                    <div class="col-sm-12" align="center">
                                        <button type="submit" name='submit' value='Submit' class="btn btn-success"><i class="fa fa-upload"></i> Publish Blog</button>
                                    </div>
                       </div>

                       <div style="margin-top: 20px;"> 
                        <div class="container">
                                    <div class="col-sm-12" align="center">
                                        <button type="submit" name='submit2' value='Submit2' class="btn btn-info"><i class="fa fa-save"></i> Draft Blog</button>
                                    </div>
                        </div>
                       </div>
                        
                      <div style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;">
                        <div class="container">
                                <h4 align="center">Tags</h4>
                            <?php	

								$sql = 'SELECT topID, topTitle FROM tagsscitech WHERE status = 1 ORDER BY topTitle';
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