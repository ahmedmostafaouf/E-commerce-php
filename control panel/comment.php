<?php
/*
--------------------------------------------------
== mange mamber page 
== you can add |edit|update|delete 
==================================================
*/
ob_start();
session_start();
$pageTitle="Comment";
if(isset($_SESSION['usersesion']))
{
  include  "init.php"; 
  $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
  //start mange page
  if($do =='mange') {  // mange member 
    
    //هجيب الكل معادا الي الادمن
    $stmt = $con->prepare("SELECT 
                             comment.*, items.name AS Item_Name, user.UserName AS Member  
                        FROM 
                            comment
                        INNER JOIN 
                            items 
                        ON 
                            items.item_id = comment.Item_id
                        INNER JOIN 
                            user
                        ON 
                            user.UserID = comment.user_id
                        ORDER BY c_id DESC");
      // هجيب البيانات دي
      $stmt->execute();
      // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
      $rows = $stmt->fetchAll();
      if(! empty($rows)){

      ?>

       <h1 class ="text-center">Mange Comment </h1>
       <div class = "container">
                <div class = "table-responsive">
                    <table class = "main-table text-center table table-bordered">
                        <tr>
                              <td>ID</td>
                              <td>Comment</td>
                              <td>Item Name</td>
                              <td>User Name</td>
                              <td>Added Date</td>
                              <td>Control</td>
                        </tr>
                        
                        <?php
                        // فور لوب هتخش تجبلي كل البيانات بتاعتي وتعرضها
                            foreach($rows as $row){
                              // هتعرضهالي اكني بشتغل اتش ت ام ال عادي 
                              echo"<tr>";
                                    echo "<td>" . $row['c_id']."</td>";
                                    echo "<td>" . $row['c_name']."</td>";
                                    echo "<td>" . $row['Item_Name']."</td>";
                                    echo "<td>" . $row['Member']."</td>";
                                    // register
                                    echo "<td>"  . $row['c_date']."</td>";
                                    // الزورارين وظفت الايدت ان اما اضغط عليه يحولني لصفحه الاديت بروفايل عشان اقدر اعدل زي ما نا عايز 
                                    echo "<td>
                                    <a href = 'comment.php?do=edit&c_id=".$row['c_id']. "'class = 'btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                    <a href = 'comment.php?do=Delete&c_id=".$row['c_id']. "'class = 'btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";
                                  //  عمل شرط بيقول لو الريج ده بصفر يعني مش متفعل حط زرار جمب الي مش متفعل 
                                    if($row['status']==0)
                                   {
                                    echo "<a href = 'comment.php?do=approve&c_id=".$row['c_id']. "'class = 'btn btn-info activate '> <i class='fa fa-check'></i> Approve </a>";
                                   }
                                   
                                   
                                    echo "</td>";
                              echo"</tr>";
                              
                            }
                        ?>
                        </table>
         </div>
       
       </div>
       <?php
      }else{
        echo "<div class='container'>";
            echo '<div class="nice-message"> There\'s No Comment To Show </div>';
        echo "</div>";   
       
}
       ?>
      
      
      <?php  }
 
elseif($do =='edit'){ //edit page
  //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
      $comid=isset ($_GET['c_id'])&& is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
         // select all data depend id   
     
         $stmt = $con-> prepare("SELECT * FROM  comment  WHERE c_id = ? ");
         //excute quary
         $stmt->execute(array($comid)); // ابحثلي عنهم فى الداتا بيز 
          // fetch
         $row = $stmt -> fetch();
            // row count  
         $count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($count>0)
           {?>   
                <h1 class ="text-center">Edit Comment</h1>
                <div class = "container">
                    <form class = "form-horizontal" action = "?do=Update" method="POST"> 
                      <input type="hidden" name="comid" value="<?php echo $comid ?>"/>
                 <!-- start comment faild -->
                        <div class="form-group form-group-lg>">
                            <label class = "col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="comment"><?php echo $row['c_name'] ?></textarea>
                            </div>
                        </div>
                  <!-- end comment faild -->
                    <!-- start button faild -->
                    <div class="form-group>">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type= "submit"value="Save" class="btn btn-primary btn-lg"/>
                            </div>
                        </div>
                  <!-- start button faild -->
                    </form>
                </div>
  <?php
        }   else {
         
          $themsg = "<div class = 'alert alert-danger'> there is no such id </div>";
         echo "<div class='container'>";

          redirecthome($themsg);
          echo "</div>";
         
        }
        // update page
      }elseif ($do=='Update') {
         echo "<h1 class='text-center'> Update comment </h1>";
         echo "<div class = 'container'>";
         if($_SERVER['REQUEST_METHOD'] == "POST")
        {       //get varible print thies el gai mn fooo2 ????
          $cid          =  $_POST['comid'];
          $comment      =  $_POST['comment'];
            //update the database
            $stmt = $con -> prepare("UPDATE comment  SET c_name = ?  WHERE c_id = ? ");
            $stmt->execute(array($comment,$cid));
            //ecoh massge success 
            $themsg = '<div class = "alert alert-success"> '.$stmt->rowCount().' record update </div>';
            // كده هيوديني ع الباك لان عارف انا جاي منين
            redirecthome($themsg,'back');
         
     
    }
    else {
      echo "<div class='container'>";
      $themsg = "<div class = 'alert alert-danger'> you cant direct </div>";
      redirecthome($themsg);
      echo "</div>";
    }
    echo "</div>";
  }
  elseif ($do=="Delete")
  {
    echo "<h1 class='text-center'> Delete Comment</h1>";
    echo "<div class = 'container'>";
     //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
        $comid=isset ($_GET['c_id'])&& is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
    
         // select all data depend id  
         $check = checkitem("c_id" , "comment" ,$comid); 
     
       //  $stmt = $con-> prepare("SELECT * FROM  user  WHERE UserID=?  LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
         //excute quary
         //$stmt->execute(array($userid)); // ابحثلي عنهم فى الداتا بيز
            // row count  
         //$count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($check>0)
           {
            $stmt = $con-> prepare("DELETE FROM comment WHERE c_id = :zid");
           // ريط
            $stmt->bindparam(":zid",$comid);
            $stmt->execute();
            $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record update </div>';
            redirecthome($themsg,'back');
          
           }
           else {
             echo "<div class='container'>";
             $themsg = "<div class = 'alert alert-danger'> Sorry You dont browes direct</div>";
             redirecthome($themsg,'back');
             echo "</div>";
          
           }
          }
           elseif ($do=="approve")
           {
             echo "<h1 class='text-center'> Activate Member</h1>";
             echo "<div class = 'container'>";
              //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
                 // check if get requset userid is numrical &get the integer value of it
                 $comid=isset ($_GET['c_id'])&& is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
             
                  // select all data depend id  
                  $check = checkitem("c_id" , "comment" ,$comid); 
              
                //  $stmt = $con-> prepare("SELECT * FROM  user  WHERE UserID=?  LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
                  //excute quary
                  //$stmt->execute(array($userid)); // ابحثلي عنهم فى الداتا بيز
                     // row count  
                  //$count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
                    // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
                     // if there is id sho form
                    if($check>0)
                    {
                     $stmt = $con-> prepare("UPDATE comment SET status = 1  WHERE c_id = ? ");
                     $stmt->execute(array($comid));
                     $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record Update </div>';
                     redirecthome($themsg);
                   
                    }
                    else {
                      echo "<div class='container'>";
                      $themsg = "<div class = 'alert alert-danger'> Sorry You dont browes direct</div>";
                      redirecthome($themsg,'back');
                      echo "</div>";
                   
                    }
                  


  }
  include $tpl  .  'fotar.php' ; 
}
//if  there is no such id sho error massage
else
{ // لو مش موجود هحوله للوجين يسجل من جديد
    //echo 'not login please login';
    header('location:index.php');
    exit();
}
ob_end_flush();
?>