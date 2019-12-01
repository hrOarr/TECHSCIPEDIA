<?php
session_start();
$_SESSION['login'] = "";
$_SESSION['profile'] = "";
//include config
include('../includes/config.php');
if(!$_SESSION['username']){ header('Location: login.php'); }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>home(admin) | TechSci Room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<style type="text/css">
	.card-counter{
    box-shadow: 2px 2px 10px #DADADA;
    margin: 5px;
    padding: 20px 10px;
    background-color: #fff;
    height: 200px;
    border-radius: 5px;
    transition: .3s linear all;
  }

  

  .card-counter.info{
    background-color: #0a2d3a;
    color: #FFF;
  }  

  .card-counter i{
    font-size: 5em;
    opacity: 0.2;
    color: black;
  }

  .card-counter .count-numbers{
    position: absolute;
    right: 45px;
    top: 80px;
    font-size: 40px;
    font-weight: bold;
    display: block;
  }

  .card-counter .count-name{
    position: absolute;
    right: 45px;
    top: 150px;
    font-style: italic;
    text-transform: capitalize;
    opacity: 0.5;
    display: block;
    font-size: 22px;
  }

</style>
<body style="background-color: #e1e8ea;">

<div class="container">
	<?php include('includes/header.php');?>


    <form style="border: 1px solid #ccc;margin-top: 40px;">
    <h3 align="center" style="padding-top: 10px;font-weight: bold;">Dashboard</h3>
    <div class="container">
    <div class="row" style="padding-top: 40px;padding-bottom: 40px;">
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="delete-editorial(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from editorialscitech";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">All blogs</span>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="publish-blogs(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from editorialscitech WHERE status = 1";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">published blogs</span>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="draft-blogs(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from editorialscitech WHERE status = 0";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">drafted blogs</span>
            </div>
        </div>

    </div>


    <div class="row" style="padding-top: 40px;padding-bottom: 40px;">
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="delete-subject(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from tagsscitech";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">All tags</span>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="delete-subject(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from tagsscitech WHERE status = 1";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">published tags</span>
            </div>
        </div>
        <div class="col-md-4 col-xs-12">
            <div class="card-counter info">
            <a href="delete-subject(scitech).php" style="text-decoration: underline;color: white;">Enter>></a>
            <?php $sql ="SELECT * from tagsscitech WHERE status = 0";
            $query = $db -> prepare($sql);;
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            $cnt=$query->rowCount();
            ?>
            <span class="count-numbers"><?php echo $cnt;?></span>
            <span class="count-name">drafted tags</span>
            </div>
        </div>

    </div>
</div>
   </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>