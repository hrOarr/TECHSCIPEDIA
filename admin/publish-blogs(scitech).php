<?php
session_start();
//include config
include('../includes/config.php');
if(!$_SESSION['username']){ header('Location: login.php'); }
//show message from add / edit page
if(isset($_GET['deledi'])){ 

	$stmt = $db->prepare('DELETE FROM editorialscitech WHERE ediID = :ediID') ;
	$stmt->execute(array(':ediID' => $_GET['deledi']));
  
  // delete from editorial subject 
	$stmt = $db->prepare('DELETE FROM editagsscitech WHERE ediID = :ediID');
	$stmt->execute(array(':ediID' => $_GET['deledi']));

	header('Location: publish-blogs(scitech).php?action=deleted');
	exit;
}

if(isset($_GET['draftid'])){
  $status = 0;
  $ediID = $_GET['draftid'];
                                
  // insert
  $stmt = $db->prepare('UPDATE editorialscitech SET status = '.$status.' WHERE ediID = '.$ediID.' ');

  $stmt->execute();

  //redirect to same page
  header('Location: publish-blogs(scitech).php?action=drafted');
  exit;
}

if(isset($_GET['sound'])){
  $ediID = $_GET['sound'];
  $stmt = $db->prepare('SELECT * FROM editorialscitech WHERE ediID = '.$ediID.' ');
  $stmt->execute();
  $row = $stmt->fetch();
  $sound = "";

  if($row['ediTitle']!=null){
    $words = explode(" ", $row['ediTitle']);
    foreach($words as $word){
      $sound .= metaphone($word)." ";
    }
  }
  $stmt = $db->prepare("UPDATE editorialscitech SET indexing = '$sound' WHERE ediID = $ediID ");
  $stmt->execute();
  $row = $stmt->rowCount();
  header('Location: publish-blogs(scitech).php?action=soundModified');
  exit;
} 

if(isset($_GET['link'])){
  $ediID = $_GET['link'];
  $stmt = $db->prepare('SELECT * FROM editorialscitech WHERE ediID = '.$ediID.' ');
  $stmt->execute();
  $row = $stmt->fetch();
  $link = 'http://localhost/techscipedia/fullviewblog(scitech).php?id='.$row['ediSlug'];
  $stmt = $db->prepare("UPDATE editorialscitech SET link = '$link' WHERE ediID = $ediID ");
  $stmt->execute();
  $row = $stmt->rowCount();
  header('Location: publish-blogs(scitech).php?action=linkAdded');
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

    <title>Published Blogs | TechSci Room</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

<script language="JavaScript" type="text/javascript">
  function deledi(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'publish-blogs(scitech).php?deledi=' + id;
	  }
  }
  function sound(id, title)
  {
    if (confirm("Are you sure you want to modified sound '" + title + "'"))
    {
      window.location.href = 'publish-blogs(scitech).php?sound=' + id;
    }
  }
  function makelink(id, title)
  {
    if (confirm("Are you sure you want to make link '" + title + "'"))
    {
      window.location.href = 'publish-blogs(scitech).php?link=' + id;
    }
  }
  </script>

</head>

<style type="text/css">
.blog-list{
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
    margin-bottom: 20px;
}
.blog-list p {
    color: rgba(0, 0, 0, 0.7);
    font-family: 'Roboto Slab', serif;
    font-size: 20px;
    padding-top: 5px;
    padding-bottom: 0px;
  }
.pagination {
    clear: both;
    padding-bottom: 10px;
    padding-top: 10px;
}
.pagination a {
    font-size: 15px;
    font-weight: bold;
    height: 25px;
    padding: 5px 5px;
    margin: 2px;
}
.pagination a:hover, .pagination a:active {
    
}
.pagination span.current {
    font-size: 15px;
    font-weight: bold;
    height: 25px;
    padding: 5px 5px;
    margin: 2px;
}
.pagination span.disabled {
    margin: 2px;
    padding: 2px 5px;
}
</style>

<body style="background-color: #e1e8ea;">
	<div class="container">
      <?php include('includes/header.php');?> 
          <div style="margin-top: 20px;">
                <div class="row">
				     <div class="col-lg-12">
				             <div class="container" style="margin-top: 20px;border: none; background-color: #fff;">
                        <div class="card" style="border: none;">
                            <div align="center">
                                <h4>Published Blogs</h4> <a href='add-editorial(scitech).php'> <button type="button" class="btn btn-dark"><i class="fa fa-sticky-note"></i>  Add New Blog</button></a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">


					                <?php 
									//show message from add / edit page
									if(isset($_GET['action'])){ 
										echo '<h3>Blog is '.$_GET['action'].'.</h3>'; 
									} 
									?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Tags</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

									  <tbody>
                                    
                                    <?php
										try {
											                                $pages = new Paginator('4','p');

                                                       $stmt = $db->query('SELECT ediID FROM editorialscitech WHERE status = 1');

                                                       //pass number of records to
                                                       $pages->set_total($stmt->rowCount());

                                                       $stmt = $db->query('SELECT * FROM editorialscitech WHERE status = 1 ORDER BY ediID DESC '.$pages->get_limit());
											while($row = $stmt->fetch()){

                                            echo '<tr>';

                                          echo '<td>'.$row['ediID'].'</td>';
                                          echo '<td>'.$row['ediTitle'].'</td>';
                                          echo '<td>';
                                          $stmt1 = $db->query('SELECT * FROM tagsscitech where topID in (select topID from editagsscitech where ediID='. $row['ediID'].')');
										  while($row1 = $stmt1->fetch()){

                                                  echo $row1['topTitle'];

                                                }
                                            echo '</td>';
                                          echo '<td>'.date('jS M Y', strtotime($row['ediDate'])).'</td>';
                                          ?>
                                                <td>
                                                	<a href="preview-blog(scitech).php?id=<?php echo $row['ediID'];?>">
                                                	<button type="button" class="btn btn-primary"><i class="fa fa-eye"></i> Preview</button></a>
                                                	<a href="edit-editorial(scitech).php?id=<?php echo $row['ediID'];?>"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a> <a href="javascript:deledi('<?php echo $row['ediID'];?>','<?php echo $row['ediTitle'];?>')"><button type="button" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
                                                  <a href="publish-blogs(scitech).php?draftid=<?php echo $row['ediID'];?>"><button type="button" class="btn btn-success"><i class="fa fa-save"></i> Draft</button></a>
                                                  <a href="javascript:sound('<?php echo $row['ediID'];?>','<?php echo $row['ediTitle'];?>')">
                                                  <button type="button" class="btn btn-primary"><i class="fas fa-assistive-listening-systems  "></i> Sound</button>
                                                  <a href="javascript:makelink('<?php echo $row['ediID'];?>','<?php echo $row['ediTitle'];?>')">
                                                  <button type="button" class="btn btn-primary"><i class="fa fa-link"></i> Link</button>
                                                  </td>
                                                	<td> 
                                                	<?php 
                                                	if($row['status']){
                                                    ?>
                                                    <p style="color: #4BB543;font-weight: bold;">published</p>
                                                    <?php
                                                  }
                                                	else echo 'pending';
                                                	?> </td>
                                            
                                            <?php 
									echo '</tr>';


										}
									echo $pages->page_links();
                                             }                             
                                             catch(PDOException $e) {
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
    </div>
     <!-- Java Scripts -->
           <?php include('includes/js.php');?> 
     <!-- End Java Scripts -->

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>