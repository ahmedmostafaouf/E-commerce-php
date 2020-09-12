<?php
 session_start();
 include 'conect.php';
 $stmt =  $con->prepare("SELECT * FROM chat WHERE other=".$_SESSION['uid'] ." AND seen=0 ");
 $stmt->execute();
 $count=$stmt->rowCount();
 if($count>0)
 {
?>
<i class="badge badge-light" style= "margin-bottom:24px;margin-left:-43px;background-color:red"> <?php echo $count; ?></i>
 <?php }?>