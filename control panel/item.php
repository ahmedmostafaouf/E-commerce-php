<?php
ob_start();
session_start();
$pageTitle="Items";
if(isset($_SESSION['usersesion']))
{
  include  "init.php"; 
  $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
  if($do =='mange') {
    $stmt = $con -> prepare("SELECT items.* 
                             , categories.name
                             AS 
                              cat_name ,user.UserName
                             FROM
                               items
                             INNER JOIN
                               categories
                             ON 
                               categories.ID = items.cat_id
                             INNER JOIN
                              user
                             ON
                               user.UserID = items.member_id
                             ORDER BY item_id DESC  ");
    // هجيب البيانات دي
    $stmt->execute();
    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
    $items = $stmt->fetchAll();
    if(! empty($items))
    {
?>
     <h1 class ="text-center">Mange Items</h1>
     <div class = "container">
              <div class = "table-responsive">
                  <table class = "main-table text-center table table-bordered">
                      <tr>
                            <td>#ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price</td>
                            <td>Date</td>
                            <td>Catogry</td>
                            <td>User Name</td>
                            <td>Control</td>
                      </tr>
                      
                      <?php
                      // فور لوب هتخش تجبلي كل البيانات بتاعتي وتعرضها
                          foreach($items as $item){
                            // هتعرضهالي اكني بشتغل اتش ت ام ال عادي 
                            echo"<tr>";
                                  echo "<td>" . $item['item_id']."</td>";
                                  echo "<td>" . $item['name']."</td>";
                                  echo "<td>" . $item['description']."</td>";
                                  echo "<td>" . $item['price']."</td>";
                                  // register
                                  echo "<td>"  . $item['add_date']."</td>";
                                  // الزورارين وظفت الايدت ان اما اضغط عليه يحولني لصفحه الاديت بروفايل عشان اقدر اعدل زي ما نا عايز 
                                  echo "<td>" . $item['cat_name']."</td>";
                                  echo "<td>" . $item['UserName']."</td>";
                                  echo "<td>
                                  <a href = 'item.php?do=edit&item_id=".$item['item_id']. "'class = 'btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                  <a href = 'item.php?do=Delete&item_id=".$item['item_id']. "'class = 'btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>
                                  <a href = 'item.php?do=show_comment&item_id=".$item['item_id']. "'class = 'btn btn-danger confirm'> <i class='fa fa-comment'></i></a>";
                                   
                                  if($item['approve']==0)
                                  {
                                   echo "<a href = 'item.php?do=approve&item_id=".$item['item_id']. "'class = 'btn btn-info activate '> <i class='fa fa-check'></i> Approve </a>";
                                  }
                                  echo "</td>";
                                 
                            echo"</tr>";
                            
                          }
                        
                      ?>
                      </table>
       </div>
     <a href = 'item.php?do=add' class = " btn btn-sm btn-primary"> <i class = "fa fa-plus"></i>  New Item</a>
     </div>
     <?php
    }else{
            echo "<div class='container'>";
                echo '<div class="nice-message"> There\'s No items To Show </div>';
                echo "<a href = 'item.php?do=add' class = ' btn btn-sm btn-primary'> <i class = 'fa fa-plus'></i>  New Item</a> ";
            echo "</div>";   
           
    }
     ?>
    
    
    <?php  
  }elseif($do == 'add'){?>
        <h1 class ="text-center">Add New Items</h1>
        <div class = "container">
            <form class = "form-horizontal" action = "?do=Insert" method="POST"> 
         <!-- start name faild -->
                <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type= "text" name="name" class="form-control"   placeholder=" Name Of The Items"/>
                    </div>
                </div>
          <!-- end  name faild -->
          <!-- start Description faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type= "text" name="description" class="form-control"   placeholder=" Description Of The Items"/>
                    </div>
                </div>
          <!-- end  Description faild -->
           <!-- start Price faild -->
           <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Price</label>
                    <div class="col-sm-10">
                        <input type= "text" name="price" class="form-control"   placeholder=" Price Of The Items"/>
                    </div>
                </div>
          <!-- end  Price faild -->
          <!-- start country faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input type= "text" name="country" class="form-control"  placeholder=" Country Of Made"/>
                    </div>
                </div>
          <!-- end country faild -->
          <!-- start status faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="0">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                </div>
          <!-- end status faild -->
            <!-- start members faild -->
            <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Members</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="member">
                            <option value="0">...</option>
                            <?php
                            $alluser = getAllfrom("*","user","","", "UserID","DESC");
                               foreach($alluser as $user){
                                    echo "<option value = '".$user['UserID']. "' >" .$user['UserName'] ." </option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
          <!-- end members faild -->
            <!-- start category faild -->
            <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="cat">
                            <option value="0">...</option>
                            <?php
                            $allcats = getAllfrom("*","categories","where parent=0","", "ID","DESC");
                            foreach($allcats as $cat){
                                echo "<option value = '".$cat['ID']. "' >" .$cat['name'] ." </option>";
                                $childcats = getAllfrom("*","categories","where parent={$cat['ID']}","", "ID","DESC");
                                foreach($childcats as $child)
                                {
                                  echo "<option value = '".$child['ID']. "' >--- " .$child['name'] ." </option>";
                                }
                            }
                        ?>
                            ?>
                        </select>
                    </div>
                </div>
          <!-- end category faild -->
          <!-- start tags faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10">
                        <input type= "text" name="tags" class="form-control"  placeholder=" Sepretar Tags With Comma (,) "/>
                    </div>
                </div>
          <!-- end tags faild -->
            <!-- start button faild -->
            <div class="form-group>">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type= "submit"value="Add Items" class="btn btn-primary btn-sm"/>
                    </div>
                </div>
          <!-- start button faild -->
            </form>
        </div>
  <?php    

  }elseif ($do=='Insert'){
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {       //get varible print thies el gai mn fooo2 ????
      echo "<h1 class='text-center'> Update Member</h1>"; // عشان متظهرلوش ف به بره اما يجي يخش دايركت
      echo "<div class = 'container'>";
      $name       =  $_POST['name'];
      $desc       =  $_POST['description'];
      $price      =  $_POST['price'];
      $country    =  $_POST['country'];
      $status     =  $_POST['status'];
      $cat        =  $_POST['cat'];
      $member     =  $_POST['member'];
      $tags       =  $_POST['tags'];
    
      //validate form
      $formerrors=array();
      if(empty($name))
      { 
        $formerrors[] = 'Name can\'t be <strong> Empty </strong> ' ;
      }
      if(empty($desc))
      { 
        $formerrors[] = 'Description can\'t be <strong> Empty </strong>  ' ;
      } 
      if(empty($price))
      { 
        $formerrors[] = 'Price can\'t be <strong> Empty </strong> ' ;
      } 
      if(empty($country))
      { 
        $formerrors[] = 'Country can\'t be <strong> Empty </strong> ' ;
      } 
      if($status==0)
      { 
        $formerrors[] = 'You Must Choose The <strong> Status </strong> ' ;
      }
      if($member==0)
      { 
        $formerrors[] = 'You Must Choose The <strong> Member </strong> ' ;
      } 
      if($cat==0)
      { 
        $formerrors[] = 'You Must Choose The <strong> Categories </strong> ' ;
      } 
      foreach($formerrors as $error)
      {
        echo '<div class = "alert alert-danger">' . $error . "</div>";
      }
      //check if there no error
      if(empty($formerrors))
      {
        //Insert user info  database
         $stmt = $con->prepare("INSERT INTO items(name,	description,price,country,status,add_date ,cat_id,member_id,tags)VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus, now() ,:zcatid ,:zmemid ,:ztags)");
         $stmt->execute(array('zname' => $name , 'zdesc' => $desc , 'zprice' => $price , 'zcountry' => $country , 'zstatus' => $status , 'zcatid' => $cat , 'zmemid' => $member , 'ztags' => $tags ));
        
        //ecoh massge success 
        $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record insert </div>';
        redirecthome($themsg,'back');
        
      }

    }
    else {
      echo "<div class = 'container'>";
    $themsg =" <div class = ' alert alert-danger '> you cant search direct </div>";
    redirecthome($themsg);
    }
    echo "</div>";

  }elseif($do =='edit'){
      // check if get requset userid is numrical &get the integer value of it
      $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
         // select all data depend id   
     
         $stmt = $con-> prepare("SELECT * FROM  items  WHERE item_id = ?");
         //excute quary
         $stmt->execute(array($itemid)); // ابحثلي عنهم فى الداتا بيز 
          // fetch
         $item = $stmt -> fetch();
            // row count  
         $count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($count>0)
           {?> 
           <h1 class ="text-center">Edit Items</h1>
        <div class = "container">
            <form class = "form-horizontal" action = "?do=Update" method="POST"> 
            <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>
         <!-- start name faild -->
                <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type= "text" name="name" class="form-control"   placeholder=" Name Of The Items"
                        value = "<?php echo $item['name'] ?>"/>
                    </div>
                </div>
          <!-- end  name faild -->
          <!-- start Description faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type= "text" name="description" class="form-control"   placeholder=" Description Of The Items"
                        value = "<?php echo $item['description'] ?>"/>
                    </div>
                </div>
          <!-- end  Description faild -->
           <!-- start Price faild -->
           <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Price</label>
                    <div class="col-sm-10">
                        <input type= "text" name="price" class="form-control"   placeholder=" Price Of The Items"
                        value = "<?php echo $item['price'] ?>" />
                    </div>
                </div>
          <!-- end  Price faild -->
          <!-- start country faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">
                        <input type= "text" name="country" class="form-control"  placeholder=" Country Of Made"
                        value = "<?php echo $item['country'] ?>"/>
                    </div>
                </div>
          <!-- end country faild -->
          <!-- start status faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="0">...</option>
                            <option value="1" <?php if($item['status']==1){ echo "selected";} ?> >New</option>
                            <option value="2" <?php if($item['status']==2){ echo "selected";} ?>>Like New</option>
                            <option value="3" <?php if($item['status']==3){ echo "selected";} ?>>Used</option>
                            <option value="4" <?php if($item['status']==4){ echo "selected";} ?>>Very Old</option>
                        </select>
                    </div>
                </div>
          <!-- end status faild -->
            <!-- start members faild -->
            <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Members</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="member">
                            <option value="0">...</option>
                            <?php
                               $alluser = getAllfrom("*","user","","", "UserID","DESC");
                                foreach($alluser as $user){
                                    echo "<option value = '".$user['UserID']. "'";
                                     if($item['member_id']==$user['UserID']){ echo "selected";} 
                                     echo ">" .$user['UserName'] ." </option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
          <!-- end members faild -->
            <!-- start category faild -->
            <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="cat">
                            <option value="0">...</option>
                            <?php
                            $allcats = getAllfrom("*","categories","where parent=0","", "ID","DESC");
                            foreach($allcats as $cat){
                                echo "<option value = '".$cat['ID']. "'";
                                if($item['cat_id']==$cat['ID']){ echo "selected";}//لو الميبر ايدي الي مجود ف جدول الايتمز = نفس اليوزر ايدي 
                                echo ">" .$cat['name'] ." </option>";
                                $childcats = getAllfrom("*","categories","where parent={$cat['ID']}","", "ID","DESC");
                                foreach($childcats as $child)
                                {
                                  echo "<option value = '".$child['ID']. "' >--- " .$child['name'] ." </option>";
                                }
                            }
                        ?>
                            ?>
                        </select>
                    </div>
                </div>
          <!-- end category faild -->
          <!-- start tags faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Tags</label>
                    <div class="col-sm-10">
                        <input type= "text" name="tags" class="form-control"  placeholder=" Sepretar Tags With Comma (,) " value = "<?php echo $item['tags'] ?>"/>
                    </div>
                </div>
          <!-- end tags faild -->
            <!-- start button faild -->
            <div class="form-group>">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type= "submit"value="Save Items" class="btn btn-primary btn-sm"/>
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

  }elseif ($do=='Update') {
    echo "<h1 class='text-center'> Update Items </h1>";
    echo "<div class = 'container'>";
    if($_SERVER['REQUEST_METHOD'] == "POST")
   {       //get varible print thies el gai mn fooo2 ????
    $id         =  $_POST['itemid'];
    $name       =  $_POST['name'];
    $desc       =  $_POST['description'];
    $price      =  $_POST['price'];
    $country    =  $_POST['country'];
    $status     =  $_POST['status'];
    $cat        =  $_POST['cat'];
    $member     =  $_POST['member'];
    $tags       =  $_POST['tags'];
  
    //validate form
    $formerrors=array();
    if(empty($name))
    { 
      $formerrors[] = 'Name can\'t be <strong> Empty </strong> ' ;
    }
    if(empty($desc))
    { 
      $formerrors[] = 'Description can\'t be <strong> Empty </strong>  ' ;
    } 
    if(empty($price))
    { 
      $formerrors[] = 'Price can\'t be <strong> Empty </strong> ' ;
    } 
    if(empty($country))
    { 
      $formerrors[] = 'Country can\'t be <strong> Empty </strong> ' ;
    } 
    if($status==0)
    { 
      $formerrors[] = 'You Must Choose The <strong> Status </strong> ' ;
    }
    if($member==0)
    { 
      $formerrors[] = 'You Must Choose The <strong> Member </strong> ' ;
    } 
    if($cat==0)
    { 
      $formerrors[] = 'You Must Choose The <strong> Categories </strong> ' ;
    } 
    foreach($formerrors as $error)
    {
      echo '<div class = "alert alert-danger">' . $error . "</div>";
    }
    //check if there no error
    if(empty($formerrors))
    {
       //update the database
       $stmt = $con -> prepare("UPDATE items  SET name = ? , description = ? , price = ? , country = ? , status =? , cat_id = ? , member_id = ? , tags=?  WHERE item_id = ? ");
       $stmt->execute(array($name,$desc,$price ,$country,$status,$cat,$member,$tags,$id));
       //ecoh massge success 
       $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record update </div>';
       // كده هيوديني ع الباك لان عارف انا جاي منين
       redirecthome($themsg,'back');
    }

}
  
else {
 echo "<div class='container'>";
 $themsg = "<div class = 'alert alert-danger'> you cant direct </div>";
 redirecthome($themsg,'back');
 echo "</div>";
}
echo "</div>";


  }elseif ($do=="Delete"){
    echo "<h1 class='text-center'> Delete Items</h1>";
    echo "<div class = 'container'>";
     //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
        $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
    
         // select all data depend id  
         $check = checkitem("item_id" , "items" ,$itemid);
           if($check>0)
         {
          $stmt = $con-> prepare("DELETE FROM items WHERE item_id = :zitemid");
         // ريط
          $stmt->bindparam(":zitemid",$itemid);
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
     

  } elseif ($do=="approve"){
    echo "<h1 class='text-center'> Activate Member</h1>";
    echo "<div class = 'container'>";
     //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
        $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
    
         // select all data depend id  
         $check = checkitem("item_id" , "items" ,$itemid);
            // if there is id sho form
           if($check>0)
           {
            $stmt = $con-> prepare("UPDATE items SET approve = 1  WHERE item_id = ? ");
            $stmt->execute(array($itemid));
            $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record Update </div>';
            redirecthome($themsg,'back');
          
           }
           else {
             echo "<div class='container'>";
             $themsg = "<div class = 'alert alert-danger'> Sorry You dont browes direct</div>";
             redirecthome($themsg,'back');
             echo "</div>";
          
           }
 

  }elseif ($do=="show_comment"){
    $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
    //start mange page
    //if($do =='mange') {  // mange member 
      
      //هجيب الكل معادا الي الادمن
      $stmt = $con->prepare("SELECT 
                               comment.*, user.UserName AS Member  
                          FROM 
                              comment
                          INNER JOIN 
                              user
                          ON 
                              user.UserID = comment.user_id
                              WHERE Item_id = ?"
                         );
        // هجيب البيانات دي
        $stmt->execute(array($itemid));
        // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
        $rows = $stmt->fetchAll();
        $count=$stmt->rowCount();
        if(! empty($rows)){
        if($count>0){
    ?>
         <h1 class ="text-center">Mange Comment </h1>
         <div class = "container">
                  <div class = "table-responsive">
                      <table class = "main-table text-center table table-bordered">
                          <tr>
                                
                                <td>Comment</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>Control</td>
                          </tr>
                          
                          <?php
                          // فور لوب هتخش تجبلي كل البيانات بتاعتي وتعرضها
                              foreach($rows as $row){
                                // هتعرضهالي اكني بشتغل اتش ت ام ال عادي 
                                echo"<tr>";
                                      
                                      echo "<td>" . $row['c_name']."</td>";
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
                            <?php }

                            }
                            else{
                              echo "<div class='container'>";
                                  echo '<div class="nice-message"> There\'s No Record To Show </div>';
                              echo "</div>";    
                            }
                        }  
                      
  include $tpl  .  'fotar.php' ; 
                      }
else
{ 
    header('location:index.php');
    exit();
}
ob_end_flush();
?>