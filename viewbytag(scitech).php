<?php 
session_start();
$_SESSION['url'] = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include('includes/config.php'); 

$stmt = $db->prepare('SELECT * FROM tagsscitech WHERE topSlug = :topSlug');
$stmt->execute(array(':topSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['topID'] == ''){
	header('Location: ./');
	exit;
}

?>
<!DOCTYPE html>
<html>
   <head>
      <title> <?php echo $row['topTitle'];?> | TECHSCIPEDIA</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta name='robots' content='index,follow'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
   </head>
   <style type="text/css">
   	.blog-list{
    background-color: #fff;
    padding: 13px;
    border-radius: 4px;
    margin-bottom: 13px;
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
   <body style="background-color: #d2dadf;">
      <div class="container">
          <?php include('includes/header.php');?>
	     <div style="margin-top: 10px;">
		<h4>Blog Tag: <?php echo $row['topTitle'];?></h4>
		<hr />
         <div class="row">
               <div class="col-md-8">
                  <div class="container" style="margin-top: 20px;background-color: #fff;">
		    <?php	
			try {

				$pages = new Paginator('4','p');

				$stmt = $db->prepare('SELECT editorialscitech.ediID FROM editorialscitech, editagsscitech WHERE editorialscitech.ediID = editagsscitech.ediID AND editorialscitech.status = 1 AND editagsscitech.topID = :topID');
				$stmt->execute(array(':topID' => $row['topID']));

				//pass number of records to
				$pages->set_total($stmt->rowCount());

				$stmt = $db->prepare('
					SELECT 
						editorialscitech.ediID, editorialscitech.ediTitle,editorialscitech.ediAuthor, editorialscitech.ediSlug, editorialscitech.ediDesc, editorialscitech.ediDate 
					FROM 
						editorialscitech,
						editagsscitech
					WHERE
						 editorialscitech.ediID = editagsscitech.ediID AND editorialscitech.status = 1
						 AND editagsscitech.topID = :topID
					ORDER BY 
						ediID DESC
					'.$pages->get_limit());

				$stmt->execute(array(':topID' => $row['topID']));
				while($row = $stmt->fetch()){
					
					echo '<div class="blog-list">';
                         echo '<h3 style="padding-bottom: 5px;"><a href="fullviewblog(scitech).php?id='.$row['ediSlug'].'" style="color:#3a9cdd;text-decoration: none;">'.$row['ediTitle'].'</a></h3>'; 

                            echo '<ul class="list-inline list-unstyled">';
                              echo '<li class="list-inline-item"><span>by </span><b style="color: #6260d0;">'.$row['ediAuthor'].'</b><span>,</span></li>';
                              // posted #days ago
                              $tim = abs(time() - strtotime($row['ediDate']));
                              $tim = ceil($tim/(60*60*24));
                              if($tim<365){
                              if($tim==1){
                              echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>day ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>days ago </span></li>';
                              }
                              }
                              else{
                                $tim = $tim/365;
                                if($tim==1){
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>year ago </span></li>';
                              }
                              else{
                                echo '<li class="list-inline-item"><b style="color:#4846bf;">'.$tim.'</b> <span>years ago </span></li>';
                              }
                              }

                $stmt2 = $db->prepare('SELECT topTitle, topSlug FROM tagsscitech, editagsscitech WHERE tagsscitech.topID = editagsscitech.topID AND editagsscitech.ediID = :ediID');
                $stmt2->execute(array(':ediID' => $row['ediID']));

                $topRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($topRow as $top)
                {
                    $links[] = "".$top['topTitle']."";
                }

                 //echo '<i class="fa fa-folder-open"></i><span style="color:#2e879a;"> Tag: '.implode(", ", $links).'</span>';

                        echo '</ul>';
                        echo '<p>'.$row['ediDesc'].
                        '<a href="fullviewblog(scitech).php?id='.$row['ediSlug'].'" style="text-decoration-line: underline;color: #3e42df;">Continue Reading<i class="fa fa-angle-double-right"></i></a></p>';

                      // Get all comments from database
                      $comments_query_result = $db->prepare("SELECT * FROM comments WHERE post_id=".$row['ediID']." ORDER BY created_at DESC");
                      $comments_query_result->execute();
                      $comments = $comments_query_result->rowCount();
                      echo '<div class="row">';
                      echo '<div class="col-md-8">';
                      echo '<button type="button" style="border-radius:12%;"><a href="fullviewblog(scitech).php?id='.$row['ediSlug'].'#jumptocomments" style="text-decoration:none;font-size:20px;">Comment</a></button>';
                      echo '</div>';
                       echo '<div class="col-md-4">';
                      echo '<h5><i class="fa fa-comments"></i><span style="font-weight:bold;"> '.$comments.' </span> Comment(s) </h5>';
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

				}

				echo $pages->page_links($_SERVER['PHP_SELF'].'?id='.$_GET['id'].'&');

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

			?>

			
			   
			      
			  
                </div>
              </div>
                
               <div class="col-md-4">
                    <?php include('includes/sidebar(scitech).php'); ?>
               </div>
            
      </div>
 </div>
      <?php include('includes/footer.php'); ?>
 </div>
   </body>
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>