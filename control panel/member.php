<?php
/*
--------------------------------------------------
== mange mamber page 
== you can add |edit|update|delete 
==================================================
*/
session_start();
$pageTitle="member";
if(isset($_SESSION['usersesion']))
{
  include  "init.php"; 
  $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
  //start mange page
  if($do =='mange') {  // mange member 
    //هنا انا عملت متغير سميت اي حاجه وقولت شرط لو البيدج الي جاي منها دي ا
    $quary='';
    if(isset($_GET['page'])&&$_GET['page']=='pending')
    {
      $quary="AND RegStatus =0";
    }
    //هجيب الكل معادا الي الادمن
      $stmt = $con -> prepare("SELECT* FROM user WHERE groupID != 1 $quary ORDER BY UserID DESC");
      // هجيب البيانات دي
      $stmt->execute();
      // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
      $rows = $stmt->fetchAll();
      if(!empty($rows)){

     ?>
       <h1 class ="text-center">Mange Member</h1>
       <div class = "container">
                <div class = "table-responsive">
                    <table class = "main-table text-center table table-bordered">
                        <tr>
                              <td>#ID</td>
                              <td>UserName</td>
                              <td>Email</td>
                              <td>FullName</td>
                              <td>Registerd Date</td>
                              <td>Control</td>
                        </tr>
                        
                        <?php
                        // فور لوب هتخش تجبلي كل البيانات بتاعتي وتعرضها
                            foreach($rows as $row){
                              // هتعرضهالي اكني بشتغل اتش ت ام ال عادي 
                              echo"<tr>";
                                    echo "<td>" . $row['UserID']."</td>";
                                    echo "<td>" . $row['UserName']."</td>";
                                    echo "<td>" . $row['Email']."</td>";
                                    echo "<td>" . $row['FullName']."</td>";
                                    // register
                                    echo "<td>"  . $row['Date']."</td>";
                                    // الزورارين وظفت الايدت ان اما اضغط عليه يحولني لصفحه الاديت بروفايل عشان اقدر اعدل زي ما نا عايز 
                                    echo "<td>
                                    <a href = 'member.php?do=edit&userid=".$row['UserID']. "'class = 'btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                    <a href = 'member.php?do=Delete&userid=".$row['UserID']. "'class = 'btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";
                                  //  عمل شرط بيقول لو الريج ده بصفر يعني مش متفعل حط زرار جمب الي مش متفعل 
                                    if($row['RegStatus']==0)
                                   {
                                    echo "<a href = 'member.php?do=activate&userid=".$row['UserID']. "'class = 'btn btn-info activate '> <i class='fa fa-check'></i> Activate </a>";
                                   }
                                   
                                   
                                    echo "</td>";
                              echo"</tr>";
                              
                            }
                        ?>
                        </table>
         </div>
       <a href = 'member.php?do=add' class = " btn btn-primary"> <i class = "fa fa-plus"></i>  New Member</a>
       </div>
       <?php
       }else{
        echo "<div class='container'>";
            echo '<div class="nice-message"> There\'s No Pending Members To Show </div>';
            echo '<a href = "member.php?do=add" class = " btn btn-primary"> <i class = "fa fa-plus"></i>  New Member</a>';
        echo "</div>";   
       
}
       ?>
      
      
      <?php  }
  elseif($do == 'add'){ ?>
    <h1 class ="text-center">Add New Member</h1>
    <div class = "container">
        <form class = "form-horizontal" action = "?do=Insert" method="POST" enctype="multipart/form-data"> 
     <!-- start user name faild -->
            <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Username</label>
                <div class="col-sm-10">
                    <input type= "text" name="username" class="form-control" autocomplete="off" required="required" placeholder=" User Name To Login In Website"/>
                </div>
            </div>
      <!-- end user name faild -->
      <!-- start password faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Password</label>
                <div class="col-sm-10">  
                    <input type= "password" name="password" class=" password form-control" autocomplete="new-password" required="required" placeholder=" password must be hard and long"/>
                    <i class = "show-pass fa fa-eye fa-2x"></i> 
                  </div>
            </div>
      <!-- end password faild -->
      <!-- start email faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type= "email" name="email" class="form-control" required="required" placeholder=" please Enter Email Valid"/>
                </div>
            </div>
      <!-- end email faild -->
      <!-- start fullname faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">FullName</label>
                <div class="col-sm-10">
                    <input type= "text" name="full" class="form-control" required="required" placeholder="FullName Apper is your Profile Page"/>
                </div>
            </div>
      <!-- end Fullname faild -->
       <!-- start avatar faild -->
       <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">User Avatar</label>
                <div class="col-sm-10">
                    <input type= "file" name="avatar" class="form-control" required="required"/>
                </div>
            </div>
      <!-- end avatar faild -->
        <!-- start button faild -->
        <div class="form-group>">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type= "submit"value="Add Membr" class="btn btn-primary btn-lg"/>
                </div>
            </div>
      <!-- start button faild -->
        </form>
    </div>
 <?php
} elseif ($do=='Insert')
{
          //insert member
         
          if($_SERVER['REQUEST_METHOD'] == "POST")
        {       //get varible print thies el gai mn fooo2 ????
          echo "<h1 class='text-center'> Update Member</h1>"; // عشان متظهرلوش ف به بره اما يجي يخش دايركت
          echo "<div class = 'container'>";
          $user     =  $_POST['username'];
          $pass     =  $_POST['password'];
          $email    =  $_POST['email'];
          $name     =  $_POST['full'];
          $hashpass = sha1($_POST['password']);
          //validate form
          $formerrors=array();
          if(strlen($user) < 4 )
          {
          $formerrors[] = ' User name cant be less than <strong> 4 char </strong>' ;
          }
          if(empty($user))
          { 
            $formerrors[] = 'User name cant be <strong> empty </strong> ' ;
          }
          if(empty($pass))
          { 
            $formerrors[] = 'Password cant be <strong> empty </strong> ' ;
          } 
          if(empty($email))
          { 
            $formerrors[] = 'Email cant be <strong> empty </strong>' ;
          } 
          if(empty($name))
          { 
            $formerrors[] = 'Fullname cant be <strong> empty </strong>' ;
          } 
          foreach($formerrors as $error)
          {
            echo '<div class = "alert alert-danger">' . $error . "</div>";
          }
          //check if there no error
          if(empty($formerrors))
          {
            //check if user insert in database
            $check = checkitem("UserName" , "user" ,$user);
            if($check==1)
            {
              $themsg = " <div class = ' alert alert-danger'> sorry the user name is exsist </div>";
              redirecthome($themsg,'back');
            }
            else{
            //Insert user info  database
             $stmt = $con->prepare("INSERT INTO user(UserName,password,Email,FullName,RegStatus,Date)VALUES(:zuser,:zpass,:zmail,:zname,1,now())");
             $stmt->execute(array('zuser' => $user , 'zpass' => $hashpass , 'zmail' => $email , 'zname' => $name));
            
            //ecoh massge success 
            $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record update </div>';
            redirecthome($themsg,'back');
            }
          }

        }
        else {
          echo "<div class = 'container'>";
        $themsg =" <div class = ' alert alert-danger '> you cant search direct </div>";
        redirecthome($themsg,'back');
        }
        echo "</div>";
}
elseif($do =='edit'){ //edit page

    /* if(isset ($_GET['userid'])&& is_numeric($_GET['userid']))//جايلي يوزر اي دي و رقم لو صح اطبعلي اليوزر ولو غلط اطبع صفر
    {
      echo intval($_GET['userid']);
    }
    else {
      echo 0;
    }
   */
  //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
      $userid=isset ($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
         // select all data depend id   
     
         $stmt = $con-> prepare("SELECT * FROM  user  WHERE UserID=?  LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
         //excute quary
         $stmt->execute(array($userid)); // ابحثلي عنهم فى الداتا بيز 
          // fetch
         $row = $stmt -> fetch();
            // row count  
         $count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($count>0)
           {?>   
                <h1 class ="text-center">Edit Member</h1>
                <div class = "container">
                    <form class = "form-horizontal" action = "?do=Update" method="POST"> 
                      <input type="hidden" name="userid" value="<?php echo $userid ?>"/>
                 <!-- start user name faild -->
                        <div class="form-group form-group-lg>">
                            <label class = "col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type= "text" name="username" class="form-control" value="<?php echo $row['UserName'] ?>"  autocomplete="off" required="required"/>
                            </div>
                        </div>
                  <!-- end user name faild -->
                  <!-- start password faild -->
                    <div class="form-group form-group-lg>">
                            <label class = "col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type= "hidden" name="oldpassword" value ="<?php echo $row['password'] ?>" />  
                                <input type= "password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="leave plan if you dont change password"/>
                            </div>
                        </div>
                  <!-- end password faild -->
                  <!-- start email faild -->
                    <div class="form-group form-group-lg>">
                            <label class = "col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type= "email" name="email" class="form-control" value="<?php echo $row['Email'] ?> " required="required" />
                            </div>
                        </div>
                  <!-- end email faild -->
                  <!-- start full name faild -->
                    <div class="form-group form-group-lg>">
                            <label class = "col-sm-2 control-label">FullName</label>
                            <div class="col-sm-10">
                                <input type= "text" name="full" class="form-control"value="<?php echo $row['FullName'] ?>" required="required" />
                            </div>
                        </div>
                  <!-- end Fullname faild -->
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
         echo "<h1 class='text-center'> Update Member</h1>";
         echo "<div class = 'container'>";
         if($_SERVER['REQUEST_METHOD'] == "POST")
        {       //get varible print thies el gai mn fooo2 ????
          $id       =  $_POST['userid'];
          $user     =  $_POST['username'];
          $email    =  $_POST['email'];
          $name     =  $_POST['full'];
          //passord trick  .... هنا لو ساب الباص فاضيه هياخد الباص القديمه لو مسبهاش فاضيه هياخد الجديده زي ما عملنا انبوت جديد للباص 
          $pass='';
        if(empty($_POST['newpassword']))
        {
            $pass = $_POST['oldpassword'];
        }
        else
         {
                $pass = sha1($_POST ['newpassword']);
         }
         //validate form
         $formerrors=array();
         if(strlen($user) < 4 )
         {
          $formerrors[] = '<div class = "alert alert-danger"> User name cant be less than <strong> 4 char </strong> </div> ' ;
         }
         if(empty($user))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> User name cant be <strong> empty </strong> </div>' ;
         } 
         if(empty($email))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Email cant be <strong> empty </strong> </div>' ;
         } 
         if(empty($name))
         { 
           $formerrors[] = '<div class = "alert alert-danger"> Fullname cant be <strong> empty </strong>  </div>' ;
         } 
         foreach($formerrors as $error)
         {
           echo '<div class = "alert alert-danger">' . $error . "</div>";
         }
         //check if there no error
         if(empty($formerrors))
         {
           //انا لو عايز اغير الاسم لاسم اصلا موجود ف الداتا بيز يعني بعمله ابديت ف بالتالي انا عشان اغير الاسم لاسم مش موجود ف الداتا بيز هعم كالتالي
           $stmt2=$con -> prepare("SELECT * FROM user WHERE UserName = ? AND UserID != ? ");//لا تساوي عشان لو جيت حدقت اي حاجه وهو يساوي هيقولك انو موجود 
           $stmt2->execute(array($user,$id));
           $count=$stmt2->rowCount();
           if($count == 1)
           {
            $themsg = ' <div class = "alert alert-success"> sorry This User is exist</div>';
             redirecthome($themsg,'back');
           }
           else{
           //update the database
            $stmt = $con -> prepare("UPDATE user  SET UserName = ? , Email = ? , FullName = ? , Password = ?  WHERE UserID = ? ");
            $stmt->execute(array($user,$email,$name,$pass ,$id));
            //ecoh massge success 
            $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record update </div>';
            // كده هيوديني ع الباك لان عارف انا جاي منين
            redirecthome($themsg,'back');
          }
         }
     
    }
    else {
      echo "<div class='container'>";
      $themsg = "<div class = 'alert alert-danger'> you cant direct </div>";
      redirecthome($themsg,'back');
      echo "</div>";
    }
    echo "</div>";
  }
  elseif ($do=="Delete")
  {
    echo "<h1 class='text-center'> Delete Member</h1>";
    echo "<div class = 'container'>";
     //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
        $userid=isset ($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    
         // select all data depend id  
         $check = checkitem("UserID" , "user" ,$userid); 
     
       //  $stmt = $con-> prepare("SELECT * FROM  user  WHERE UserID=?  LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
         //excute quary
         //$stmt->execute(array($userid)); // ابحثلي عنهم فى الداتا بيز
            // row count  
         //$count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($check>0)
           {
            $stmt = $con-> prepare("DELETE FROM user WHERE UserID = :zuser");
           // ريط
            $stmt->bindparam(":zuser",$userid);
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
           elseif ($do=="activate")
           {
             echo "<h1 class='text-center'> Activate Member</h1>";
             echo "<div class = 'container'>";
              //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
                 // check if get requset userid is numrical &get the integer value of it
                 $userid=isset ($_GET['userid'])&& is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
             
                  // select all data depend id  
                  $check = checkitem("UserID" , "user" ,$userid); 
              
                //  $stmt = $con-> prepare("SELECT * FROM  user  WHERE UserID=?  LIMIT 1  ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
                  //excute quary
                  //$stmt->execute(array($userid)); // ابحثلي عنهم فى الداتا بيز
                     // row count  
                  //$count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
                    // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
                     // if there is id sho form
                    if($check>0)
                    {
                     $stmt = $con-> prepare("UPDATE user SET RegStatus = 1  WHERE UserID = ? ");
                     $stmt->execute(array($userid));
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