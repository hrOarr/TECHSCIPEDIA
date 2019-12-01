<?php 
include('includes/config.php'); 
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Archives(Science And Techonology) | TechSci Room</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name='robots' content='index,follow'>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
   </head>
   <body style="background-color: #eaf1f6;">
      <div class="container">
      	<?php include('includes/header.php');?>
	     <div style="margin-top: 20px;">
	 	 <h1>Blog</h1>
		<hr/>

         <div class="row">
               <div class="col-md-8">
                  <div class="container" style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;">
					
				  
				  <?php
				try {

					//collect month and year data
					$month = $_GET['month'];
					$year = $_GET['year'];

					//set from and to dates
					$from = date('Y-m-01 00:00:00', strtotime("$year-$month"));
					$to = date('Y-m-31 23:59:59', strtotime("$year-$month"));


					$pages = new Paginator('4','p');

					$stmt = $db->prepare('SELECT ediID FROM editorialscitech WHERE ediDate >= :from AND ediDate <= :to');
					$stmt->execute(array(
						':from' => $from,
						':to' => $to
				 	));

					//pass number of records to
					$pages->set_total($stmt->rowCount());

					$stmt = $db->prepare('SELECT * FROM editorialscitech WHERE ediDate >= :from AND ediDate <= :to ORDER BY ediID DESC '.$pages->get_limit());
					$stmt->execute(array(
						':from' => $from,
						':to' => $to
				 	));
					while($row = $stmt->fetch()){
					
					echo '<div class="blog-list">';
                         echo '<h3 style="padding-bottom: 5px;"><a href="edifullview(scitech).php?id='.$row['ediSlug'].'" style="color:#3a9cdd;text-decoration: none;">'.$row['ediTitle'].'</a></h3>'; 

                            echo '<ul class="list-inline list-unstyled">';
                              echo '<li><span>by </span>'.$row['ediAuthor'].'</li>';
                              echo '<li><span>Created On:</span> '.date('jS M Y', strtotime($row['ediDate'])).'</li>';

                $stmt2 = $db->prepare('SELECT topTitle, topSlug FROM tagsscitech, editagsscitech WHERE tagsscitech.topID = editagsscitech.topID AND editagsscitech.ediID = :ediID');
                $stmt2->execute(array(':ediID' => $row['ediID']));

                $topRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                $links = array();
                foreach ($topRow as $top)
                {
                    $links[] = "<a href='c-".$top['topSlug']."'>".$top['topTitle']."</a>";
                }

                 echo '<i class="fa fa-folder-open"></i><span> Tag: </span>'.implode(", ", $links).'';

                           echo '</ul>';
                        echo '<p>'.$row['ediDesc'].'</p>';
                        echo '<a href="edifullview(scitech).php?id='.$row['ediSlug'].'" style="text-decoration-line: underline;color: #3e42df;">Continue Reading<i class="fa fa-angle-double-right"></i></a>'; 
                      echo '</div>';

				}

				echo $pages->page_links("a-$month-$year&");

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
     <?php include ('includes/footer.php'); ?>
     </div>
   </body>
   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
   </html>