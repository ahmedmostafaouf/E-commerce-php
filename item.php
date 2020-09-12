<?php
ob_start();
session_start();
$pageTitle= "Show Items";
include 'init.php';
  // check if get requset userid is numrical &get the integer value of it
  $itemid=isset ($_GET['item_id'])&& is_numeric($_GET['item_id']) ? intval($_GET['item_id']) : 0;
  // select all data depend id   

  $stmt = $con-> prepare("SELECT
                          items.* , categories.name   
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
                        WHERE
                            item_id=?
                        AND
                            approve=1");
  //excute quary
  $stmt->execute(array($itemid)); // ابحثلي عنهم فى الداتا بيز 
   // fetch
  $count= $stmt->rowCount();
  if($count>0){
    $item = $stmt -> fetch();
?>  
<h1 class='text-center'> <?php echo $item['name'] ?> </h1> 
<div class="container">
    <div class="row">
        <div class="col-md-3">
             <img class="img-responsive img-thumbnail center-block" src="img.jpg" alt="" />
        </div>
        <div class="col-md-9 item-info">
                       <h2> <?php echo $item['name'] ?></h2>        
                        <p> <?php echo $item['description'] ?></p>
                    
                    <ul class="list-unstyled">
                    <li>
                        <i class='fa fa-calendar fa-fw'></i>
                        <span>Date</span> : <?php echo $item['add_date'] ?>
                    </li>
                    <li>
                    <i class='fa fa-money fa-fw'></i>
                        <span>Price</span> : $<?php echo $item['price'] ?>
                    </li>
                    <li>
                        <i class='fa fa-calendar fa-fw'></i>
                        <span>Made In</span> : <?php echo $item['country'] ?>
                    </li>
                    <li>
                        <i class='fa fa-tags fa-fw'></i>
                        <span>category</span> : <a href="cats.php?pageid=<?php echo $item['cat_id'] ?> "> <?php echo $item['cat_name'] ?> </a>
                    </li>
                    <li>
                        <i class='fa fa-calendar fa-fw'></i>
                        <span>Add By</span> :  <?php echo $item['UserName'] ?>
                        <a href ="chat.php?friend=<?php echo $item['member_id'] ?>" class ='pull-right confirm' style='font-size:29px; color:black; margin-top:-9px;'> <i class='fab fa-facebook-messenger'></i></a>
                    </li>
                    <li class="tags-items">
                        <i class='fa fa-user fa-fw'></i>
                        <span>Tags</span> : 
                        <?php
                        // عملت للعنصر ده اكسبلود وحطيته  ف اراي
                        $alltags = explode("," ,$item['tags']);
                        foreach($alltags as $tag){
                            $tag = str_replace(' ','',$tag);
                            $lowertag = strtolower($tag);
                            if(!empty($tag)){
                           echo "<a href='tags.php?name={$lowertag}'>" . $tag . "</a>";
                        }
                    }
                          ?>  
                    </li>
                </ul>
         </div>
    </div>
    <?php  if(isset($_SESSION['user'])){?>
    <!-- Start add comment-->
    <hr class="custom-hr">
       <div class="row">
           <div class="col-md-offset-3">
           <div class="add-comment">
                <h3>Add Your Comment </h3>
                <!-- هنا هيودي ع نفس الصفحه -->
                <form  action="<?php echo $_SERVER['PHP_SELF'] .'?item_id='.$item['item_id'] ?>" method='POST'>
                        <textarea name="comment"required></textarea>
                        <input class="btn btn-primary" type="submit" value="Add Comment">
                </form>
                <?php 
                // لو الشخص جاي عن طريق البوست هطبع الكومنت بتاعه
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                        $itemid  =  $item['item_id'];
                        // عشان اما اجي اكتب الكومنت الي اليوزر الي فاتح بيه يظهر ب اسمه مش ب اسم الي منزل الايتم
                        $userid  = $_SESSION['uid'];
                        if(!empty($comment)){
                            $stmt = $con->prepare("INSERT INTO comment(c_name,status,c_date,Item_id,user_id) VALUE(:zname,0,now(),:zitem,:zuser )");
                            $stmt->execute(array(
                               'zname'=>$comment,
                               'zitem'=>$itemid,
                               'zuser'=>$userid

                            ));
                            if($stmt){
                                echo "<div class='alert alert-success'> Comment Add </div>";
                            }
                        }else{
                            echo "<div class='alert alert-danger'> You Must Add Comment </div>";
                        }
                        
                    }
                
                
                ?>
           </div>
           </div>
       </div>
       <!-- End add comment-->
    <?php }else{
         echo "<a href='login.php'> Login </a> Or <a href='login.php'> Register </a> To Add Comment ";
    } ?>
    <hr class="custom-hr">
    <?php 
              $stmt = $con->prepare("SELECT 
                                             comment.*, user.UserName AS Member  
                                    FROM 
                                             comment
                                    INNER JOIN 
                                             user
                                    ON 
                                             user.UserID = comment.user_id
                                    WHERE 
                                             Item_id=? 
                                    AND
                                             status=1          
                                    ORDER BY
                                             c_id DESC");
                    // هجيب البيانات دي
                    $stmt->execute(array($itemid));
                    // هحط البيات الي هتطلع ف متغيركده هيجيب البيانات كلها من الداتا بيز وهيعرضها
                    $comments = $stmt->fetchAll();          
                            ?>
                         <?php
                        foreach($comments as $comment){ ?>
                          <div class="comment-box">
                                <div class ='row'> 
                                            <div class= 'col-sm-2 text-center' >
                                            <img class="img-responsive img-thumbnail img-circle center-block" src="img.jpg" alt="" />
                                            <?php echo $comment['Member'] ?>
                                            </div>  
                                            <div class= 'col-sm-10'> 
                                            <p class="lead"> <?php echo $comment['c_name'] ?></p>
                                            </div>           
                                </div>
                          </div>
                          <hr class="custom" >

                      <?php  } ?>

                           
    
</div>
                          

        <?php
        }else
        {  echo "<div class=container>";
            echo ' <div class="alert alert-danger">There Is No Such Id Or Items Waitig Aprroval </div>';
        }  echo "</div>";

        include $tpl  .  'fotar.php' ; 
        ob_end_flush();

        ?>

