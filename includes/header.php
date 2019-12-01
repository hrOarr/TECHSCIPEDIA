<style type="text/css">
    .dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}
.dropbtn{
    font-size: 22px;  
  border: none;
  color: black;
  background-color: inherit;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
<?php

?>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: white;">
  <a class="navbar-brand" href="blogs_scitech.php" style="font-family: Times New Roman;font-size: 40px;margin-left: 0px;">
  <img src="image/site-logo.png" style="width: 50px;height: 50px;border-radius: 50%;">
  TECHSCIPEDIA
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar" aria-controls="myNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
  <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="navbar-nav ml-auto">
    <?php
      if(!$_SESSION['login'])
      {
    ?>
    <li><a href="sign-in(user).php" style="text-decoration: underline;">Sign In</a></li>
    <span>&nbsp &nbsp</span>
    <li><a href="sign-up(user).php" style="text-decoration: underline;">Register</a></li>
    <?php 
  }
  else{
    ?>
    <li><a href="myprofile.php" style="text-decoration: underline;"><?php echo $_SESSION['login']; ?></a></li>
    <span>&nbsp &nbsp</span>
    <li><a href="logout(user).php" style="text-decoration: underline;">Log out</a></li>
    <?php
  }
  ?>
  </ul>
</div>
</nav>
