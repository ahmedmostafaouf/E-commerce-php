<?php
session_start();
$pageTitle= "Create New Items";
include 'init.php';
if(isset($_SESSION['user'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
         $formErrors = array();
         $name       =  filter_var($_POST['name'],FILTER_SANITIZE_STRING);
         $desc       =  filter_var($_POST['description'],FILTER_SANITIZE_STRING);
         $price      =  filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
         $country    =  filter_var($_POST['country'],FILTER_SANITIZE_STRING);
         $status     =  filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
         $cat        =  filter_var($_POST['cat'],FILTER_SANITIZE_NUMBER_INT);
         $tags       =  filter_var($_POST['tags'],FILTER_SANITIZE_STRING);
         if(strlen($name)<4)
         {
             $formErrors[] ="Item Title Must Be At Least 4 char";
         }
         if(strlen($desc)<10)
         {
             $formErrors[] ="Item description Must Be At Least 10 char";
         }
         if(strlen($country)<2)
         {
             $formErrors[] ="Item country Must Be At Least 2 char";
         }
         if(empty($price))
         {
             $formErrors[] ="Item price Must Be Not Empty";
         }
         if(empty($cat))
         {
             $formErrors[] ="Item category Must Be Not Empty";
         }
         if(empty($status))
         {
             $formErrors[] ="Item status Must Be Not Empty";
         }
          //check if there no error
      if(empty($formErrors))
      {
        //Insert user info  database
         $stmt = $con->prepare("INSERT INTO items(name,	description,price,country,status,add_date ,cat_id,member_id,tags)VALUES(:zname,:zdesc,:zprice,:zcountry,:zstatus, now() ,:zcatid ,:zmemid,:ztags)");
         $stmt->execute(array('zname' => $name , 'zdesc' => $desc , 'zprice' => $price , 'zcountry' => $country , 'zstatus' => $status , 'zcatid' => $cat , 'zmemid' => $_SESSION['uid'],'ztags' =>$tags ));
        
        //ecoh massge success
        if($stmt){ 
        $successmsg = " Item Has Been Added";
        }
      }
    }
?>  
<h1 class='text-center'> <?php echo $pageTitle ?>  </h1>     
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class='panel-heading'> <?php echo $pageTitle ?> </div>
            <div class='panel-body'>
                <div class="row">
                    <div class="col-md-8">
                    <form class = "form-horizontal main-form" action ="<?php echo $_SERVER['PHP_SELF'] ?>" ? method="POST"> 
         <!-- start name faild -->
                <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input pattern="{4,}" title="This Field Required At Laest 4 Char " type= "text" name="name" class="form-control live-name"   placeholder=" Name Of The Items"  required/>
                    </div>
                </div>
          <!-- end  name faild -->
          <!-- start Description faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input pattern="{4,}" title="This Field Required At Laest 4 Char " type= "text" name="description" class="form-control live-desc"   placeholder=" Description Of The Items" required/>
                    </div>
                </div>
          <!-- end  Description faild -->
           <!-- start Price faild -->
           <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Price</label>
                    <div class="col-sm-10">
                        <input type= "text" name="price" class="form-control live-price"   placeholder=" Price Of The Items" required/>
                    </div>
                </div>
          <!-- end  Price faild -->
          <!-- start country faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Country</label>
                    <div class="col-sm-10">

                        <input type= "text" name="country" class="form-control"  placeholder=" Country Of Made" required/>
                    </div>
                </div>
          <!-- end country faild -->
          <!-- start status faild -->
          <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status" required>
                            <option value="">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                </div>
          <!-- end status faild -->
            <!-- start category faild -->
            <div class="form-group form-group-lg>">
                    <label class = "col-sm-2 control-label">category</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="cat" required>
                            <option value="">...</option>
                            <?php
                              $cats = getAllfrom('*','categories','','','ID','DESC');
                            foreach($cats as $cat){
                                echo "<option value = '".$cat['ID']. "' >" .$cat['name'] ." </option>";
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
          <!-- end button faild -->
            </form>
                   </div> 
                   <div class="col-md-4">
                   <div class="thumbnail item-box live-preview">
                                      <span class="price-tag">$0</span>
                                      <img class="img-responsive" src="img.jpg" alt="" />
                                      <div class = "caption">
                                        <h3>name</h3>
                                          <p>description</p>
                                      </div>
                                  </div>
                   </div>
                </div> 
                <!-- Start Looping Through Errors -->
                <?php 
                   if(!empty($formErrors)){
                       foreach($formErrors as $error)
                       {
                           echo "<div class= 'alert alert-danger'>". $error . "</div>";
                       }
                    }
                    if(isset($successmsg)){
                     
                        echo '<div class="alert alert-success"> '.  $successmsg .' </div>';
                  
                      }
                ?>
                <!-- End Looping Through Errors -->
            </div>    
        </div>    
    </div>    
</div>    

                  
<?php
}else{
    header('location: login.php');
    exit();
}
include $tpl  .  'fotar.php' ; 

?>

