<?php
session_start();
$pageTitle="member";
if(isset($_SESSION['usersesion']))
{
  include  "init.php"; 
  $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
  if($do =='mange') {
  } elseif($do == 'add'){ 

  }elseif ($do=='Insert'){

  }elseif($do =='edit'){ 

  }elseif ($do=='Update') {

  }elseif ($do=="Delete"){

  }
  include $tpl  .  'fotar.php' ; 
  else
{ // لو مش موجود هحوله للوجين يسجل من جديد
    //echo 'not login please login';
    header('location:index.php');
    exit();
}


