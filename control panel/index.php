<?php
session_start();
$nonavbar='';
$pageTitle= "login";// ده الي جاي من الفانكشن هيبقي اسم التايتل  وهكذا ف الداش بورد
include 'init.php';
if(isset($_SESSION['usersesion'])) //دخلت لقتني مسجل حولني ع الداش بورد
{
  header('location:dashpoard.php');

}


// user coming from http post request
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $username=$_POST['user'];
    $password=$_POST['pass'];
    $hachedpass=sha1($password);//ده حمايه للباص عشان متخشش ف الداتا بيز يشوفها 
   //check the user exist in DB
   $stmt = $con-> prepare("SELECT
                                UserID, UserName , password
                           FROM
                                 user
                            WHERE
                                 UserName=?
                            AND
                                password=?
                            AND
                               groupID=1
                            LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
   $stmt->execute(array($username,$hachedpass)); // ابحثلي عنهم فى الداتا بيز
  $row = $stmt -> fetch();
   $count = $stmt -> rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
   //echo $count; لو موجود يبقي 1 لو مش موجود يبقي 0
   // if count >0 this main about database contain record about this user name

   if($count>0)
   {
     $_SESSION['usersesion']=$username; //سجلت السيشن بيوزر ال جاي من الفورم
     $_SESSION['ID']= $row ['UserID'];// سشن لليوزر اي دي بتاعي 
     header('location:dashpoard.php'); //هيجولني لصفحه دي لو لقاه السيشن
     exit();
     //echo "welcome " . $username;
   }
  }
?>
       <!--   <?php
         
         echo lang('MASSAGE') . " ".  lang('admin'); // استدعي الفنكشن الي فيها اراي
         ?> -->
         <form class= "login" action ="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST'>
         <h4 class="text-center"> Admin Login </h4>
         <input class="form-control"  type="text" name="user" placeholder="username" autocomplete="off"/>
         <input class="form-control " type="password" name="pass" placeholder="password" autocomplete="off"/>
         <input class="btn btn-primary btn-block"type="submit"value="login"/>
         </form>
         <?php include $tpl  .  'fotar.php' ; ?>
