<!DOCTYPE html>
<html>
    <head>
            <meta charset="UTF-8"/> 
            <title> <?php  gettitle() ?> </title>
            <link rel="stylesheet" href ="<?php echo $css; ?>bootstrap.min.css"/>
            <link rel="stylesheet" href ="<?php echo $css; ?>font-awesome.min.css"/>
            <link rel="stylesheet" href ="<?php echo $css; ?>front.css"/>
            <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    </head> 
</html>
<body>
<div class="  upper-bar" style="background-color: #2d2c2c;">
    <div class='container'>
      <?php
     //هنا انااا ف البار الي فوق لو انا مسجل السيشن هيشيل اللوجن ويقولي ويلكم لو مش مسجل هيجبلي اللوجن
      if(isset($_SESSION['user'])) //دخلت لقتني مسجل حولني ع الداش بورد
      { ?>
      <img class="my-img img-thumbnail img-circle" src="www.jpg" alt="" />
         <div class="btn-group">
            <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <?php echo $_SESSION['user'] ?>
            <span class="caret"></span>
            </span>
            <ul class="dropdown-menu" >
              <li><a href="profile.php">My Profile</a> </li>
              <li><a href="newad.php">Create Items</a> </li>
              <li><a href="profile.php#my-ads">My Items</a> </li>
              <li><a href="logout.php">Log Out</a> </li>
            </ul>
       
      
         </div>
         <script>
                setInterval(function(){
                 $('#msgCounter').load('counter.php');
                });
                </script>
         <a href ="inbox.php" class ='pull-right confirm' style='font-size:36px; color:#eee;'> <i class='fab fa-facebook-messenger'><i id="msgCounter" ></i></i></a>
      <?php

      }else{
      ?>
        <a href="login.php">
          <span class=" btn btn-default pull-right">Login/Signup</span>
        </a> 
       
      <?php } ?> 
      
    </div>
</div>
<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php
          $getallcats=getAllfrom("*","categories","where parent=0","","ID","ASC");
           foreach($getallcats as $cat)
           {
               echo '<li>
                          <a href="cats.php?pageid='. $cat['ID'].'">
                                '. $cat['name'] . 
                         '</a>
                    </li>';
           }   
          
        ?>
      </ul>
    </div>
  </div>
</nav>