<?php
include('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Search Results | TECHSCIPEDIA</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>

<body style="background-color: #eaf1f6;">
  <div class="container">
  <?php include('includes/header.php');?>
	<div style="margin-top: 20px;">
            <div class="row">
                    <div class="col-md-12">
                        <div class="container" style="margin-top: 20px;border: 1px solid #ccc;background-color: #fff;">
                        	<div style="margin-top: 20px;margin-bottom: 40px;">
                        	<?php
                        	  if(isset($_POST['submit'])){
	                      $query = $_POST['search'];
	                      $search = explode(" ", $query);
	                      $search_str = "";
	                      foreach($search as $word){
		                    $search_str .= metaphone($word)." "; 
	                      }
	                      $stmt = $db->prepare("SELECT * FROM editorialscitech WHERE status=1 AND indexing like '%$search_str%' ");
	                      $stmt->execute();
                           $cnt = $stmt->rowCount();
                           if($cnt==0){
                           	echo "No result is found!"."<br>";
                           	?>
                           	<p>Your search is <b style="font-weight: bold;"><?php echo htmlentities($query); ?></b> - didn't match any documents. </p>
                           	Suggestions:
                           	<ul>
                           		<li>Make sure that all words are spelled correctly.</li>
                           		<li>Try again with related keywords.</li>
                           	</ul>
                           	<?php
                           }
                           else{
                           	echo "Found about ".$cnt." results"."<br>"."<br>";
     	                    while($row = $stmt->fetch()){
     	                      	?>
     	                      	<a href="<?php echo $row['link'];?>">
     	                      	<?php
     		                    echo $row['ediTitle']."<br>";
     		                    ?>
     		               </a>
     		               <?php
     	                  }
                           }
                          } 
                        	?>
                        </div>
                        </div>
                   </div>
            </div>
    </div>
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>