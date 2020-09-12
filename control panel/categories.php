<?php
ob_start();
session_start();
$pageTitle="Categories";
if(isset($_SESSION['usersesion']))
{
  include  "init.php"; 
  $do = isset($_GET['do']) ? $_GET['do'] : 'mange';
  if($do =='mange') {
      
    $sort='ASC';//ده االقيمه الافتراضيه للترتيب 
    $sort_array=array('ASC','DESC');//دي اراي انا حطيت القيمه بتاعتي الاتنين دول عشان ميحطش قيمه 3
    //هل فيه ركوست جاي من الصفحه بالاسم ده ولا لاء ولو فيه جاي وف نفس الوقت ف الاراي
    if(isset($_GET['sort'])&&in_array($_GET['sort'],$sort_array)){
            $sort=$_GET['sort'];

    }
      $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent =0 ORDER BY ordaring $sort");
      $stmt2->execute();
     $cats = $stmt2->fetchAll();
     if(!empty($cats)){

     ?>
     <h1 class="text-center">Manage Categories</h1>
			<div class="container categories">
				<div class="panel panel-default">
                    <div class="panel-heading"> <i class="fa fa-edit"></i>  Manage Categories 
                       
                        <div class="option pull-right">
                            Ordering: [
                            <a class="<?php if($sort=='ASC'){echo 'Active';} ?>"href="?sort=ASC"> Asc</a> |
                            <a class="<?php if($sort=='DESC'){echo 'Active';} ?>"href="?sort=DESC"> Desc</a> ]
                            View: [ <span class="Active" data-view='full'> Full </span> |
                            <span data-view='classic'> Classic </span> ]
                        </div>
                    </div>
                    <div class="panel-body">
    <?php
                foreach($cats as $cat)
                {
                    echo "<div class = 'cat'>";
                       echo "<div class = 'hidden-buttons'>"; 
                               echo "<a href='categories.php?do=edit&catid=".$cat['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a> ";  
                               echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class=' confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a> ";
                       echo"</div>";
                        echo '<h3>'. $cat['name'] ."</h3>";
                        echo '<div class="full-view">';
                                echo '<p>'; if($cat['description']==''){ echo " This IS categories no descriphion ";} else{ echo $cat['description'];} echo "</p>";
                                //low el e3lan hid as =1 ha3mel span b colcor mo3ain
                                if($cat['visabilty']==1){ echo'<span class = "visabilty"><i class="fa fa-eye"></i> Hidden</span>';}
                                if($cat['allow_comment']==1){ echo'<span class = "coment"><i class="fa fa-close"></i>Comment Disabled</span>';}
                                if($cat['allow_ads']==1){ echo'<span class = "advertises"><i class="fa fa-close"></i> Advertises Disabled</span>';}
                        echo "</div>";
                        $childcats=getAllfrom("*","categories","where parent={$cat['ID']}","","ID","ASC");
                        if(!empty($childcats)){
                        echo "<h4 class='child-head'> Child Categories </h4>";
                        echo "<ul class='list-unstayled child-cats'>";
                                    foreach($childcats as $c)
                                    { 
                                        
                                        echo "<li  class = 'child-link'>
                                        <a href='categories.php?do=edit&catid=".$c['ID']."' class = 'child-link'>" .$c['name']. "</a>
                                        <a href ='categories.php?do=Delete&catid=".$c['ID']."' class=' show-delete confirm' > Delete </a>
                                        </li>"; 
                                    } 
                        echo "</ul>"; 
                    } 
                    echo "</div>";
                                 
                    echo "<hr>";
                           

                }
    ?>
                   </div>
               </div>
               <a class=" add-cat btn btn-primary" href="categories.php?do=add"> <i class="fa fa-plus"></i> New Catogry </a>
        </div>
        <?php
     }
        else{
            echo "<div class='container'>";
                echo '<div class="nice-message"> There\'s No category To Show </div>';
                echo '<a class=" add-cat btn btn-primary" href="categories.php?do=add"> <i class="fa fa-plus"></i> New Catogry </a>';
            echo "</div>";   
           
    }
        ?>
        

  <?php } elseif($do == 'add'){?>
    <h1 class ="text-center">Add New Categories</h1>
    <div class = "container">
        <form class = "form-horizontal" action = "?do=Insert" method="POST"> 
     <!-- start name faild -->
            <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type= "text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Categories"/>
                </div>
            </div>
      <!-- end  name faild -->
      <!-- start descripthion faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">description</label>
                <div class="col-sm-10">  
                    <input type= "text" name="description" class=" form-control"   placeholder=" descripe the categoreis"/> 
                  </div>
            </div>
      <!-- end descripthion faild -->
      <!-- start ordaring faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Ordaring</label>
                <div class="col-sm-10">
                    <input type= "text" name="ordaring" class="form-control"  placeholder=" Number to arrange the categories"/>
                </div>
            </div>
      <!-- end ordaring faild -->
       <!-- start parent faild -->
       <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">parent</label>
                <div class="col-sm-10">
                    <select name="parent" class="form-control">
                           <option value="0">None</option>
                           <?php
                             $Allcats =  getAllfrom("*","categories","where parent=0","", "ID","ASC" );
                             foreach($Allcats as $all)
                             {
                                 echo "<option value='" . $all['ID']."'>" . $all['name']."</option>"; 
                             }
                           ?>
                           
                    
                    </select>
                </div>
            </div>
      <!-- end parent faild -->
      <!-- start visibilty faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Visability</label>
                <div class="col-sm-10">
                    <div>
                        <input id="vis-yes" type="radio" name="visability" value="0" checked />
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "vis-no" type="radio" name="visability" value="1" />
                        <label for="vis-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end visabilty faild -->
        <!-- start allow-comment faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Allow Comment</label>
                <div class="col-sm-10">
                    <div>
                        <input id="com-yes" type="radio" name="comment" value="0" checked />
                        <label for="com-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "com-no" type="radio" name="comment" value="1" />
                        <label for="com-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end allow-comment faild -->
        <!-- start ads faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Ads</label>
                <div class="col-sm-10">
                    <div>
                        <input id="ads-yes" type="radio" name="ads" value="0" checked />
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "ads-no" type="radio" name="ads" value="1" />
                        <label for="ads-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end ads faild -->
        <!-- start button faild -->
        <div class="form-group>">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type= "submit"value="Add Categories" class="btn btn-primary btn-lg"/>
                </div>
            </div>
      <!-- start button faild -->
        </form>
    </div>
  
  
  <?php

  }elseif ($do=='Insert'){
       //insert member
         
       if($_SERVER['REQUEST_METHOD'] == "POST")
       {       //get varible print thies el gai mn fooo2 ????
         echo "<h1 class='text-center'> Insert Categories</h1>"; // عشان متظهرلوش ف به بره اما يجي يخش دايركت
         echo "<div class = 'container'>";
         $name       =  $_POST['name'];
         $desc       =  $_POST['description'];
         $parent     =  $_POST['parent'];
         $order      =  $_POST['ordaring'];
         $vis        =  $_POST['visability'];
         $com        =  $_POST['comment'];
         $ads        =  $_POST['ads'];
           //check if user insert in database
           $check = checkitem("name", "categories" ,$name);
           if($check==1)
           {
             $themsg = "<div class = ' alert alert-danger'> sorry the user name is exsist </div>";
             redirecthome($themsg,'back');
           }
           else{
           //Insert user info  database
            $stmt = $con->prepare("INSERT INTO categories(name,description,parent,ordaring,visabilty,allow_comment,allow_ads) VALUES (:zname,:zdesc,:zparent,:zorder,:zvis,:zcom,:zads)");
            $stmt->execute(array('zname' => $name , 'zdesc' => $desc ,'zparent' =>$parent , 'zorder' => $order , 'zvis' => $vis , 'zcom' => $com , 'zads' => $ads));
           
           //ecoh massge success 
           $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().'record update </div>';
           redirecthome($themsg,'back');
           }
         

       }
       else {
         echo "<div class = 'container'>";
       $themsg =" <div class = ' alert alert-danger '> you cant search direct </div>";
       redirecthome($themsg,'back');
       }
       echo "</div>";

  }elseif($do =='edit'){ 
         // check if get requset userid is numrical &get the integer value of it
         $catid=isset ($_GET['catid'])&& is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
         // select all data depend id   
     
         $stmt = $con-> prepare("SELECT * FROM  categories  WHERE ID=? ");//group id =1 (معني كدنه الي عنده جروب ايدي ب واحد هو الادمن ويخش)
         //excute quary
         $stmt->execute(array($catid)); // ابحثلي عنهم فى الداتا بيز 
          // fetch
         $cat = $stmt -> fetch();
            // row count  
         $count=$stmt->rowCount(); // بيشيك هل الي انا كتبته موجود ف الداتا بيز ولا لاء 
           // الاي دي جاي من الداتا بعد اما عملت اتشك ولا لاء 
            // if there is id sho form
           if($count>0)
           {?>   
                <h1 class ="text-center">Edit Categories</h1>
                <div class = "container">
                    <form class = "form-horizontal" action = "?do=Update" method="POST"> 
                      <input type="hidden" name="catid" value="<?php echo $catid ?>"/>
                 <!-- start name faild -->
            <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type= "text" name="name" class="form-control"  required="required" placeholder="Name Of The Categories" value = "<?php echo $cat['name']?>"/>
                </div>
            </div>
      <!-- end  name faild -->
      <!-- start descripthion faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">description</label>
                <div class="col-sm-10">  
                    <input type= "text" name="description" class=" form-control" placeholder=" descripe the categoreis" value = "<?php echo $cat['description']?>"/> 
                  </div>
            </div>
      <!-- end descripthion faild -->
      <!-- start ordaring faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Ordaring</label>
                <div class="col-sm-10">
                    <input type= "text" name="ordaring" class="form-control"  placeholder=" Number to arrange the categories" value="<?php echo $cat['ordaring'] ?>" />
                </div>
            </div>
      <!-- end ordaring faild -->
       <!-- start parent faild -->
       <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">parent</label>
                <div class="col-sm-10">
                    <select name="parent" class="form-control">
                           <option value="0">None</option>
                           <?php
                             $Allcats =  getAllfrom("*","categories","where parent=0","", "ID","ASC" );
                             foreach($Allcats as $all)
                             {
                                 echo "<option value='" . $all['ID']."'";
                                 if($cat['parent']==$all["ID"]){ echo 'selected';}
                                 echo ">". $all['name']."</option>"; 
                             }
                           ?>
                           
                    
                    </select>
                </div>
            </div>
      <!-- end parent faild -->
      <!-- start visibilty faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Visability</label>
                <div class="col-sm-10">
                    <div>
                        <input id="vis-yes" type="radio" name="visability" value="0" checked />
                        <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "vis-no" type="radio" name="visability" value="1" />
                        <label for="vis-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end visabilty faild -->
        <!-- start allow-comment faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Allow Comment</label>
                <div class="col-sm-10">
                    <div>
                        <input id="com-yes" type="radio" name="comment" value="0" checked />
                        <label for="com-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "com-no" type="radio" name="comment" value="1" />
                        <label for="com-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end allow-comment faild -->
        <!-- start ads faild -->
        <div class="form-group form-group-lg>">
                <label class = "col-sm-2 control-label">Ads</label>
                <div class="col-sm-10">
                    <div>
                        <input id="ads-yes" type="radio" name="ads" value="0" checked />
                        <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                        <input id= "ads-no" type="radio" name="ads" value="1" />
                        <label for="ads-no">No</label>
                    </div>
                </div>
            </div>
      <!-- end ads faild -->
        <!-- start button faild -->
        <div class="form-group>">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type= "submit"value="Add Categories" class="btn btn-primary btn-lg"/>
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
    echo "<h1 class='text-center'> Update Member</h1>";
    echo "<div class = 'container'>";
    if($_SERVER['REQUEST_METHOD'] == "POST")
   {       //get varible print thies el gai mn fooo2 ????
    $id 		= $_POST['catid'];
    $name 		= $_POST['name'];
    $desc 		= $_POST['description'];
    $order 		= $_POST['ordaring'];
    $parent     = $_POST['parent'];
    $visible 	= $_POST['visability'];
    $comment 	= $_POST['comment'];
    $ads 		= $_POST['ads'];

    // Update The Database With This Info

    $stmt = $con->prepare("UPDATE 
                                categories 
                            SET 
                                name = ?, 
                                description = ?, 
                                ordaring = ?,
                                parent = ?, 
                                visabilty = ?,
                                allow_comment = ?,
                                allow_ads = ? 
                            WHERE 
                                ID = ?");

    $stmt->execute(array($name, $desc, $order,$parent, $visible, $comment, $ads, $id));

    // Echo Success Message

    $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

       // كده هيوديني ع الباك لان عارف انا جاي منين
       redirecthome($themsg,'back');
    

}
else {
 echo "<div class='container'>";
 $themsg = "<div class = 'alert alert-danger'> you cant direct </div>";
 redirecthome($themsg,'back');
 echo "</div>";
}
echo "</div>";

  }elseif ($do=="Delete"){echo "<h1 class='text-center'> Delete Catogery</h1>";
    echo "<div class = 'container'>";
     //هنا جمله اف بقولو هل الجيت الي جايلي من فوق هو رقم  و يوزر اي دي لو صح اطبعه لو غلط ايرور
        // check if get requset userid is numrical &get the integer value of it
        $catid=isset ($_GET['catid'])&& is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
    
         // select all data depend id  
         $check = checkitem("ID" , "categories" ,$catid); 
           if($check>0)
           {
            $stmt = $con-> prepare("DELETE FROM categories WHERE ID = :zid");
           // ريط
            $stmt->bindparam(":zid",$catid);
            $stmt->execute();
            $themsg = ' <div class = "alert alert-success"> ' . $stmt->rowCount().' record delete </div>';
            redirecthome($themsg,'back');
        }
        else {
          echo "<div class='container'>";
          $themsg = "<div class = 'alert alert-danger'> Sorry You dont browes direct</div>";
          redirecthome($themsg,'back');
          echo "</div>";
       
        }

  }

  include $tpl  .  'fotar.php' ; 
}else
{ // لو مش موجود هحوله للوجين يسجل من جديد
    //echo 'not login please login';
    header('location:index.php');
    exit();
}



ob_end_flush();
?>