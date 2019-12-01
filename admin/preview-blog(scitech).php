<?php 
session_start();
include('../includes/config.php'); 
if(!$_SESSION['username']){ header('Location: login.php'); }
$stmt = $db->prepare('SELECT * FROM editorialscitech WHERE ediID = :ediID');
$stmt->execute(array(':ediID' => $_GET['id']));
$row = $stmt->fetch();
//if post does not exists redirect user.
if($row['ediTitle'] == ''){
	header('Location: ./');
	exit;
}
 ?>
<!DOCTYPE html>
<html>
   <head>
      <title> <?php echo $row['ediTitle'];?> | TECHSCIPEDIA</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name='keywords' content='<?php echo $row['ediTitle'];?>'>
		<meta name='description' content='<?php echo $row['ediCont']; ?>'>
		<meta name='language' content='en'>
      <meta name="robots" content="noindex, nofollow">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
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
   </style>
  <body style="background-color: #e1e8ea;">
    <div class="container">
      <?php include('includes/header.php');?> 
            <div style="margin-top: 20px;">

            <div class="row">

                    <div class="col-md-8">
                        <div class="container" style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;">
                    
                  <?php	
                  echo '<div class="blog-list">';
                 echo '<h3 style="padding-bottom: 10px;"><a style="color:#3a9cdd;text-decoration: none;">'.$row['ediTitle'].'</a></h3>'; 

                            echo '<ul class="list-inline list-unstyled">';
                              echo '<li><span>by </span>'.$row['ediAuthor'].'</li>';
                              echo '<li><span>Created On:</span> '.date('jS M Y', strtotime($row['ediDate'])).'</li>';

                $stmt2 = $db->prepare('SELECT topTitle, topSlug FROM tagsscitech, editagsscitech WHERE tagsscitech.topID = editagsscitech.topID AND editagsscitech.ediID = :ediID');
                $stmt2->execute(array(':ediID' => $row['ediID']));

                $topRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($topRow as $top)
                {
                    $links[] = "".$top['topTitle']."";
                }

                 echo '<i class="fa fa-folder-open"></i><span style="color:#2e879a;"> Tag: '.implode(", ", $links).'</span>';

                           echo '</ul>';
                        echo '<p>'.$row['ediDesc'].
                        $row['ediCont'].'</p>';
                  echo '</div>';
               ?>
              
			   
			      
			  
                </div>
              </div>
                
               <div class="col-md-4">

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