<?php
session_start();
//include config
include('../includes/config.php');
if(!$_SESSION['username']){ header('Location: login.php'); }
//show message from add / edit page
if(isset($_GET['deltop'])){ 

	$stmt = $db->prepare('DELETE FROM tagsscitech WHERE topID = :topID') ;
	$stmt->execute(array(':topID' => $_GET['deltop']));

	header('Location: delete-subject(scitech).php?action=deleted');
	exit;
}

if(isset($_GET['pubid'])){
  $status = 1;
  $topID = $_GET['pubid'];
                                
  // insert
  $stmt = $db->prepare('UPDATE tagsscitech SET status = '.$status.' WHERE topID = '.$topID.' ');

  $stmt->execute();

  //redirect to same page
  header('Location: delete-subject(scitech).php?action=published');
  exit;
}

if(isset($_GET['draftid'])){
  $status = 0;
  $topID = $_GET['draftid'];
                                
  // insert
  $stmt = $db->prepare('UPDATE tagsscitech SET status = '.$status.' WHERE topID = '.$topID.' ');

  $stmt->execute();

  //redirect to same page
  header('Location: delete-subject(scitech).php?action=drafted');
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>All Tags | TechSci Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
   
  <script language="JavaScript" type="text/javascript">
  function deltop(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'delete-subject(scitech).php?deltop=' + id;
	  }
  }
  </script>

</head>

<body style="background-color: #e1e8ea;">
    <div class="container">
      <?php include('includes/header.php');?> 
	
            <div style="margin-top: 20px;">
                
                <div class="row">
				    <div class="col-lg-12">
                        <div class="card">


                            <div align="center">
                                <h4>All Tags</h4> <a href='add-subject(scitech).php'> <button type="button" class="btn btn-dark"><i class="fa fa-plus"></i> Add New Tag</button></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <?php 
                                    //show message from add / edit page
                                    if(isset($_GET['action'])){ 
                                        echo '<h3>Tag is '.$_GET['action'].'.</h3>'; 
                                    } 
                                    ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

									  <tbody>
                                    
                                          
                                        <?php
                                            try {

                                                $stmt = $db->query('SELECT topID, topTitle, topSlug,status FROM tagsscitech ORDER BY topTitle ASC');
                                                while($row = $stmt->fetch()){

                                                echo '<td>'.$row['topID'].'</td>';
                                                echo '<td>'.$row['topTitle'].'</td>';
                                                ?>
                                                
                                                <td><a href="edit-subject(scitech).php?id=<?php echo $row['topID'];?>"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a> <a href="javascript:deltop('<?php echo $row['topID'];?>','<?php echo $row['topSlug'];?>')"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
                                                <?php
                                                if($row['status']){
                                                    ?>
                                                    <a href="delete-subject(scitech).php?draftid=<?php echo $row['topID'];?>"><button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Draft</button></a>
                                                    <?php
                                                }
                                                else{
                                                    ?>
                                                    <a href="delete-subject(scitech).php?pubid=<?php echo $row['topID'];?>"><button type="button" class="btn btn-primary"><i class="fa fa-upload"></i> Publish</button></a>
                                                    <?php
                                                }
                                                ?>
                                                </td>
                                                
                                                <td> 
                                                    <?php 
                                                    if($row['status']){
                                                      ?>
                                                    <p style="color: #4BB543;font-weight: bold;">published</p>
                                                    <?php
                                                    }
                                                    else{
                                                      ?>
                                                    <p style="color: #CCCC00;font-weight: bold;">pending</p>
                                                    <?php
                                                    }
                                                    ?> </td>
                                            <?php 
												echo '</tr>';

											}

										} catch(PDOException $e) {
										    echo $e->getMessage();
										}
									?>
                                            
                                        </tbody>
                                    </table>
                                </div>
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